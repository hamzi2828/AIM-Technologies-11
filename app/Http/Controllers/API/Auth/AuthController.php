<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\ApiController;
use App\Models\AppSettings;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;


class AuthController extends ApiController
{
   public function __construct(){
   //    $this->middleware('can:update,user')->only('deactivateAccount','changePassword');
   }

    // This function checks password
    private function doMagic(Request $request) {

        if (!AuthController::hasInput($request)) {
            return false;
        }
        // Get the user from database by email
        $user = User::where('username', $request['username'])->firstOrFail();


        // Now compare if the user entered password is correct
        if($user->sha1 == 0 && $user->password === md5($request['password']) && $user->status == 'active') {

                    if(Auth::loginUsingId($user->user_id)){
                        return true;
                    } else {
                        return false;
                    }

        } else if($user->sha1 == 1 && $user->password === md5(sha1($request['password'])) && $user->status == 'active') {

                if(Auth::loginUsingId($user->user_id)){
                        return true;
                    } else {
                        return false;
                    }

        } else {
            return false;
        }


    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(),[
            'fname' => 'required|string|max:255',
            'username' => 'required|string|email|max:255|unique:cashbackengine_users',
            'password' => 'required|string|min:8',
            'country' => 'required|integer',
            'ref' => 'integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'fname' => $request->fname,
            'username' => $request->username,
            'password' => md5(sha1($request->password)),
            'country' => $request->country,
            'ref_id' => $request->ref ? $request->ref : 0,
            'sha1' => 1,
            'ip' => $request->ip()
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        //add referal bonus to referal user
        //get referal bonus from settings table
        //add entry to transaction table with status pending
   /*     $referUser = User::where('user_id', $request->ref_id)->firstOrFail();
        if($request->ref_id && $user && $referUser){
            $creditAmount = AppSettings::where('setting_key','refer_credit')->firstOrFail();
            if($creditAmount){
                $transaction = Transaction::create([
                    'payment_type' => Transaction::TYPE_FRIEND_BONUS,
                    'reference_id' => $this->GenerateRandString(10, "0123456789"),
                    'user_id' => $referUser->user_id,
                    'transaction_amount' => $creditAmount->setting_value,
                    'amount' => $creditAmount->setting_value,
                    'status' => Transaction::STATUS_PENDING,
                    'created' => now()
                ]);
            }
            else{
                return response()
                    ->json(['data' => null,'msg' => "Credit amount is empty" ]);
            }
        } 
    */
        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer' ]);
    }

    public function login(Request $request)
    {
        if (!AuthController::doMagic($request))
        {

                return response()
                ->json(['message' => 'Unauthorized'], 401);


        }
        $user = User::where('username', $request['username'])->firstOrFail();

        $user->update([
            'last_login' => Carbon::now()->toDateTimeString(),
            'last_ip' => $request->getClientIp(),
            'last_device' => $request->header('User-Agent'),
            'reg_source' => ($request->has('reg_source') && $request->reg_source !=null && $request->reg_source != $user->reg_source) ? $request->reg_source : $user->reg_source,
        ]);
        $user->increment('login_count', 1);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        if(auth('sanctum')->check()) {
            $user = DB::table('cashbackengine_users')
                ->where('username', auth('sanctum')->user()->username)
                ->update(['reg_source' => null]);
            Auth::user()->tokens()->delete();

            return response()->json([
                'message' => 'You have successfully logged out and the token was successfully deleted'
            ]);

        } else {
            return response()->json(['message' => 'Please login first!']);
        }
    }


    public function deactivateAccount(Request $request) {

        if(auth('sanctum')->check()) {

            $user = DB::table('cashbackengine_users')
                    ->where('username', auth('sanctum')->user()->username)
                    ->update(['status' => User::INACTIVE, 'deleted_at'=>Carbon::now()]);


            if($user) {
                return response()->json(['message' => 'User Deactivated']);
            } else {
                return response()->json(['message' => 'Something went wrong']);
            }
        } else {
            return response()->json(['message' => 'Please login first!']);
        }



    }

    function GenerateRandString($len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
    {
        $string = '';
        for ($i = 0; $i < $len; $i++)
        {
            $pos = rand(0, strlen($chars)-1);
            $string .= $chars[$pos];
        }
        return $string.'A';
    }
    public function changePassword(Request $request) {

        if(auth('sanctum')->check()) {
            $user = auth('sanctum')->user();
            $validator = Validator::make($request->all(),[
            'newPassword' => 'required|string|min:8|different:currentPassword',
            'currentPassword' => 'required'
            ]);
            if($validator->fails()){
                return response()->json($validator->errors());
            }
            if (md5(sha1($request['currentPassword'])) !=  $user->getAuthPassword()) {
                return response()->json(['message' => 'Current Password is wrong']);
            }
            $newPassword = md5(sha1($request['newPassword']));
            $user = DB::table('cashbackengine_users')
                        ->where('username', $user->username)
                        ->update(['password' => $newPassword, 'sha1' => 1]);
            if($user) {
                return response()->json(['message' => 'Password Changed!']);
            } else {
                return response()->json(['message' => 'Something went wrong']);
            }

        } else {
            return response()->json(['message' => 'Please login first!']);
        }


    }

    public function viewUser(Request $request) {

        $user = User::where('username', $request['username'])->firstOrFail();


        return response()->json(['username' => $user->username, 'password' => $user->password, 'status' => $user->status, 'sha1' => $user->sha1]);
    }


     private function hasInput(Request $request)
    {
        return count($request->all()) > 0; //or return count($request->all()) > 1;

    }

    /**
 * Social Login
 */
public function socialLogin(Request $request)
{
    $provider = $request->input('provider_name'); //facebook
    $token = $request->input('access_token');
    // get the provider's user. (In the provider server)
    $providerUser = Socialite::driver($provider)->userFromToken($token);
    // check if access token exists etc..
    // search for a user in our server with the specified provider id and provider name
    $user = User::where('provider_name', $provider)->where('provider_id', $providerUser->id)->firstOrFail();
    // if there is no record with these data, create a new user
    if($user == null){
        $user = User::create([
            'provider_name' => $provider,
            'provider_id' => $providerUser->id,
        ]);
    }
    // create a token for the user, so they can login
    $token = $user->createToken(env('APP_NAME'))->accessToken;
    // return the token for usage
    return response()->json([
        'success' => true,
        'token' => $token
    ]);
}


}
