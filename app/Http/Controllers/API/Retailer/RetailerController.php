<?php



namespace App\Http\Controllers\API\Retailer;



use App\Http\Controllers\API\ApiController;

use App\Models\Click;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Retailer;
use App\Transformers\RetailerTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class RetailerController extends ApiController

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {
        $token = $request->bearerToken();
        $user_id=0;
        if($token){
            $tokend = PersonalAccessToken::findToken($token);
            if($tokend && $tokend->tokenable()){
                $user_id = $tokend->tokenable->user_id;
                Session::put('userId',$tokend->tokenable->user_id);
            }

        }
        $retailers = Retailer::filter($request)

        ->orderBy('visits','DESC')
        ->with('coupons');
        if($user_id > 0 ){
            $retailers->with(['favoritess'=> function($q) use($user_id) {
                $q->where('user_id', '=', $user_id);
            }]);
        }
        $retailers = $retailers->get();
        $includes = explode(',', \Request::get('include'));

        if (in_array('coupons', $includes)) $retailers->load('coupons');

        if (in_array('categories', $includes)) $retailers->load('categories');
        //return $this->showWith($retailers, new RetailerTransformer);

        return $this->showAll($retailers);


    }
    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function searchRetailor()

    {



    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

    }



    /**

     * Display the specified resource.

     *

     * @param  Retailer  $retailer

     * @return \Illuminate\Http\Response

     */

    public function show(Retailer $retailer,Request $request)
    {
        return $this->showOne($retailer);
    }
    public function updateHistory(Request $request){
        $validationMessage = [
            'retailer_id.required' => __('validation.required' , ['attribute' => __('Reatiler Id cannot be empty.')]),
        ];
        $firstFormRules = array(
            'retailer_id' => 'required');
        $v1 = Validator::make($request->all(), $firstFormRules, $validationMessage);
        if ($v1->fails()) {
            return response()->json($v1->errors());
        }
        $retailer = Retailer::find($request->retailer_id);
        $token = $request->bearerToken();
        if($token){
            $tokend = PersonalAccessToken::findToken($token);
            if($tokend && $tokend->tokenable()){
                Click::create([
                    'click_ref' => $this->GenerateRandString(10, "0123456789"),
                    'user_id' => $tokend->tokenable->user_id,
                    'retailer_id' => $request->retailer_id,
                    'retailer' => $retailer->title,
                    'click_ip' => $request->ip(),
                ]);
            }

        }
        $retailer->increment('mobile_visits', 1);
        return response()->json([
            'data' => $retailer->retailer_id,
            'message' => __('Click history added successfully!'),
            'success' => true
        ]);
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

    /**

     * Show the form for editing the specified resource.

     *

     * @param  Retailer $retailer

     * @return \Illuminate\Http\Response

     */

    public function edit(Retailer $retailer)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }

    public function featured() {
        $retailers = Retailer::where('featured',Retailer::FEATURED_RETAILER)->get();
        return $this->showAll($retailers);
    }

    public function week() {
        $retailers = Retailer::where('deal_of_week',Retailer::STORE_OF_WEEK)->get();
        return $this->showAll($retailers);
    }

    public function startsWith($letter){
        $retailers = Retailer::where('title', 'like', $letter.'%' )->get();
        return  $this->showAll($retailers);
    }



    public function autocomplete(Request $request)
    {
         $retailers = Retailer::where("title","like",$request->input('query').'%')
                //->orWhere("title","LIKE","{%$request->input('query')}%")
              //  ->orWhere("title","LIKE","{Slugify::getSlug($request->input('query'))}%")
                ->get();
        return $this->showAll($retailers);
    }

     public function lastMonth() {
        $retailers = Retailer::where('added', '>=',Carbon::now()->subMonth())->get();
        return $this->showAll($retailers);
    }

      protected function eagerLoadIncludeCategories(Request $request, Builder $query)
    {
        $requestedIncludes = $this->fractal->getRequestedIncludes();

        if (in_array('categories', $requestedIncludes)) {
            $query->with('categories');
        }

        return $query;
    }

}
