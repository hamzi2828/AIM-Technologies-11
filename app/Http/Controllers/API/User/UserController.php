<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\ApiController;
use App\Models\AppSettings;
use App\Models\UserNotification;
use App\Transformers\NotificationTransformer;
use App\Transformers\TransactionTransformer;
use Faker\Core\Number;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController {

    public function __construct() {
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');

    }

    /**
     * Display the resource of the logged in user.
     *
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
     public function index() {
         $user = auth()->user();
      //   $transactions = Transaction::where('user_id',$user->user_id)->get();
         return $this->showOne($user);
     }


     /**
     * Display the specified resource. GET method
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       return $this->showOne($user);
    }

        /**
     * Remove the specified resource from storage. DELETE Method
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }

        /**
     * Update the specified resource in storage. PUT method
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'username' => 'email|unique:'.User::Class.',username,' . $user->user_id,
            'password' => 'min:6|confirmed',
         //   'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];

        $this->validate($request, $rules);

        if ($request->has('fname')) {
            $user->fname = $request->fname;
        }
        if ($request->has('lname')) {
            $user->lname = $request->lname;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('country')) {
            $user->country = (int)$request->country;
        }

        if ($request->has('username') && $user->username != $request->username) {
            $user->validated = User::NOT_VALIDATED_USER;
            $user->activation_key = User::generateKey($request->username);
            $user->username = $request->username;
        }

    //    if ($request->has('password')) {
    //        $user->password = bcrypt($request->password);
    //    }

   /*     if ($request->has('admin')) {
            $this->allowedAdminAction();

            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }

            $user->admin = $request->admin;
        }
*/
        //User didn't change
        if (!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $user->save();
        $user->save();

        return $this->showOne($user);
    }
    public function getUserTotalBalance(Request $request)
    {
        $pending_balance= null;
        $pending_payment= null;
        $declined_balance= null;
        $withdraw_balance= null;
        $confirmed_balance= null;
        $total_balance = $this->GetUserBalance(auth('sanctum')->user()->user_id, $request->status);
        if ($request->filled('status') && $request->status == Transaction::STATUS_PENDING || $request->status == Transaction::STATUS_ALL){
            $pending_balance = $this->getUserBalanceStatus(auth('sanctum')->user()->user_id, Transaction::STATUS_PENDING);
        }
        if ($request->filled('status') && $request->status == Transaction::STATUS_REQUEST || $request->status == Transaction::STATUS_ALL){
            $pending_payment = $this->getUserBalanceStatus(auth('sanctum')->user()->user_id, Transaction::STATUS_REQUEST);
        }
        if ($request->filled('status') && $request->status == Transaction::STATUS_DECLINED || $request->status == Transaction::STATUS_ALL){
            $declined_balance = $this->getUserBalanceStatus(auth('sanctum')->user()->user_id,Transaction::STATUS_DECLINED);
        }
        if ($request->filled('status') && $request->status == Transaction::STATUS_PAID || $request->status == Transaction::STATUS_ALL){
            $withdraw_balance = $this->GetCashOutWithdrawl(auth('sanctum')->user()->user_id,Transaction::STATUS_PAID);
        }
        if ($request->filled('status') && $request->status == Transaction::STATUS_CONFIRMED || $request->status == Transaction::STATUS_ALL){
            $confirmed_balance = $this->userConfirmBalance(auth('sanctum')->user()->user_id,Transaction::STATUS_CONFIRMED);
        }

        return response()->json(['success' => 'true','total_balance' => number_format($total_balance, 2) ,'pending_balance' => $pending_balance,'declined_balance' =>$declined_balance,'withdrawn_balance' => $withdraw_balance,'pending_payment' => $pending_payment,'confirm_payment' => $confirmed_balance]);
    }
    private function getUserBalanceStatus($user_id,$status)
    {
        $result = DB::select("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$user_id."' AND status='".(string)$status."'");
        if($result > 0){
            if($result[0]->total){
                return $result[0]->total;
            }
        }
        return 0;
    }
    private function userConfirmBalance($user_id,$status){
        $result = DB::select("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$user_id."' AND status='".(string)$status."'");
        if($result > 0){
            if($result[0]->total){
                return $result[0]->total;
            }
        }
        return 0;
    }
    public function getUserReferal(Request $request){
        $transaction = User::where('ref_id','=',auth('sanctum')->user()->user_id)->get();
        return $this->showAll($transaction);
    }
    public function getTransactionHistory(Request $request){
        $transaction = Transaction::where('user_id','=',auth('sanctum')->user()->user_id)->get();
        return $this->showAll($transaction);
    }
    public function getTransactionDetails(Request $request)
    {
        $transaction = Transaction::where('transaction_id','=',$request->transaction_id)->get();
        return $this->transformData($transaction,TransactionTransformer::class);
    }
    public function userWithDrawRequest(Request $request)
    {
        $validationMessage = [
            'payment_method.required' => __('validation.required' , ['attribute' => __('Payment method cannot be empty.')]),
            'amount.required' => __('validation.required' , ['attribute' => __('Amount cannot be empty.')]),
            'details.required' => __('validation.required' , ['attribute' => __('Details cannot be empty.')]),
        ];
        $firstFormRules = array(
            'payment_method' => 'required|in:bank,paypal',
            'details' => 'required',
            'amount' => 'required',
            );
        $v1 = Validator::make($request->all(), $firstFormRules, $validationMessage);
        $v1->after(function ($v1) use ($request) {
            $withDrawlLimit = AppSettings::where('setting_key',Transaction::MIN_PAYOUT)->first();

            if(!$withDrawlLimit){
                $v1->errors()->add('setting_error', "Setting Value is missing from App Settings");
            }
            if($request->amount < intval($withDrawlLimit->setting_value) ){
                $v1->errors()->add('min_payout', "Το ζητούμενο ποσό είναι μικρότερο από την ελάχιστη πληρωμή {$withDrawlLimit->setting_value}Є");
            }
            if($request->amount > $this->GetUserBalance(auth('sanctum')->user()->user_id)){
                $v1->errors()->add('low_balance', 'Το διαθέσιμο υπόλοιπο στον λογαριασμό σας είναι λιγότερο από το ποσό που έχετε ζητήσει');
            }
        });
        if ($v1->fails()) {
            return response()->json($v1->errors());
        }

        $payment_type ='';
        if($request->payment_method =='paypal'){
            $payment_type = Transaction::PAYMENT_METHOD_PAYPAL;
        }
        else if($request->payment_method =='bank'){
            $payment_type = Transaction::PAYMENT_METHOD_BANK;
        }
        $transaction = Transaction::create([
            'reference_id' =>  $this->GenerateRandString(10, "0123456789"),
            'user_id' =>  auth('sanctum')->user()->user_id,
            'payment_type' => Transaction::TYPE_WITHDRAWAL,
            'payment_method' =>$payment_type,//paypal or bank
            'payment_details' =>  $request->details,
            'amount' => $request->amount ,//The amount asked to withdraw
            'status' => Transaction::STATUS_REQUEST,
            'created' => now()
            ]);
        return response()->json([
            'data' => $transaction,
            'success' => true,
            'message' => __('Withdrawl request has been added.')
        ]);
    }
    public function GetCashOutWithdrawl($user_id,$status)
    {
        $result = DB::select("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$user_id."' AND  status='".(string)$status."'");
        if($result > 0){
            if($result[0]->total){
                return $result[0]->total;
            }
        }
        return 0;
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
 * Returns member's referrals total
 * @param	$userid		User's ID
 * @return	string		member's referrals total
*/


	public function GetReferralsTotal($userid)
	{
		$query = "SELECT COUNT(*) AS total FROM cashbackengine_users WHERE ref_id='".(int)$userid."' AND ref_id>=20000";
		$result = smart_mysql_query($query);

		if (mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			return $row['total'];
		}
	}

/**
 * Returns member's ref pending bonuses
 * @param	$userid		User ID
 * @return	string		ref pending bonuses
*/


	public function GetReferralsPendingBonuses($userid)
	{
		$query = "SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND payment_type='friend_bonus' AND status='pending'";
		$result = smart_mysql_query($query);

		if (mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			return DisplayMoney($row['total']);
		}
	}

	/**
 * Returns member's ref paid bonuses
 * @param	$userid		User ID
 * @return	string		ref paid bonuses
*/


	public function GetReferralsPaidBonuses($userid)
	{
		$query = "SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND payment_type='friend_bonus' AND status='".Transaction::STATUS_CONFIRMED."'";
		$result = smart_mysql_query($query);

		if (mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			return DisplayMoney($row['total']);
		}
	}


/**
 * Returns member's ref link clicks
 * @param	$userid		User ID
 * @return	string		ref link clicks total
*/


	public function GetRefClicksTotal($userid)
	{
		$query = "SELECT ref_clicks AS total FROM cashbackengine_users WHERE user_id='".(int)$userid."' LIMIT 1";
		$result = smart_mysql_query($query);

		if (mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			return $row['total'];
		}
	}



	public function GetAllReferrals($userid)
	{

		$refs_query = "SELECT *, DATE_FORMAT(created, '". DATE_FORMAT ." %h:%i %p') AS signup_date FROM cashbackengine_users WHERE ref_id='". $userid ."' ORDER BY created DESC";
		$refs_result = smart_mysql_query($refs_query);

		$referrals_array = [];
		if(mysqli_num_rows($refs_result) > 0){

			while ($row = mysqli_fetch_array($refs_result))
			{
				$referrals_array[] = [
					'user_id' => $row['user_id'],
					'username' => $row['username'],
					'status' => $row['status'],
					'signup_date' => $row['signup_date'],
				];
			}
		}

		return $referrals_array;
	}



	public function GetAllInvites($userid)
	{

		$refs_query = "SELECT *, DATE_FORMAT(sent_date, '". DATE_FORMAT ." %h:%i %p') AS sent_date FROM cashbackengine_invitations WHERE user_id='". $userid ."' ORDER BY sent_date DESC";
		$refs_result = smart_mysql_query($refs_query);

		$referrals_array = [];
		if(mysqli_num_rows($refs_result) > 0){

			while ($row = mysqli_fetch_array($refs_result))
			{
				$recipient = str_replace('>', '', $row['recipients']);
				$recipient = str_replace('<', '', $recipient);
				$recipient = trim($recipient);

				$referrals_array[] = [
					'user_id' => $row['user_id'],
					'recipients' => $recipient,
					'sent_date' => $row['sent_date'],
				];
			}
		}

		return $referrals_array;
	}



	public function GetAllInvitesWithTransactions($userid)
	{

		$refs_query = "SELECT u.*
						FROM cashbackengine_users u
						LEFT JOIN cashbackengine_transactions t ON (t.user_id = u.user_id)
 						WHERE u.user_id='". $userid ."'
 						 AND t.retailer_id != 0
 						ORDER BY created DESC";
		$refs_result = smart_mysql_query($refs_query);

		$referrals_array = [];
		if(mysqli_num_rows($refs_result) > 0){

			while ($row = mysqli_fetch_array($refs_result))
			{
				$referrals_array[] = [
					'user_id' => $row['user_id'],
					'username' => $row['username'],
					'status' => $row['status'],
					'signup_date' => $row['signup_date'],
				];
			}
		}

		return $referrals_array;
	}




/**
 * Returns  member's current balance
 * @param	$userid					User's ID
 * @param	$hide_currency_option	Hide or show currency sign
 * @return	string					member's current balance
*/


	public function GetUserBalance($userid, $hide_currency_option = 0)
	{
        $result = DB::select("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND status='".Transaction::STATUS_CONFIRMED."'");

		if ($result != 0)
		{
			if ($result[0]->total > 0)
			{
				$row_paid = DB::select("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND ((status='paid' OR status='request') OR (payment_type='Withdrawal' AND status='declined'))");
				$balance = $result[0]->total - $row_paid[0]->total;

                return $balance;
			}
			else
			{
                return 0;
			}
		}
		else
		{
            return 0;
		}
	}



/**
 * Returns date of last transaction
 * @param	$userid		User's ID
 * @return	mixed		date of last transaction or false
*/


	public function GetBalanceUpdateDate($userid)
	{
		$result = smart_mysql_query("SELECT DATE_FORMAT(updated, '".DATE_FORMAT." %h:%i %p') AS last_process_date FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' ORDER BY updated DESC LIMIT 1");
		if (mysqli_num_rows($result) != 0) {
			$row = mysqli_fetch_array($result);
			return $row['last_process_date'];
		} else {
			return false;
		}

	}



/**
 * Add/Deduct money from member's balance
 * @param	$userid		User's ID
 * @param	$amount		Amount
 * @param	$action		Action
*/


	public function UpdateUserBalance($userid, $amount, $action)
	{
		$userid = (int)$userid;

		if ($action == "add")
		{
			smart_mysql_query("INSERT INTO cashbackengine_transactions SET user_id='$userid', amount='$amount', status='".Transaction::STATUS_CONFIRMED."'");
		}
		elseif ($action == "deduct")
		{
			smart_mysql_query("INSERT INTO cashbackengine_transactions SET user_id='$userid', amount='$amount', status='deducted'");
		}
	}



/**
 * Returns member's pending cashback
 * @return	string	member's pending cashback
*/


	public function GetPendingBalance()
	{
		global $userid;
		$result = smart_mysql_query("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND status='pending'");
		$row = mysqli_fetch_array($result);
		$total = DisplayMoney($row['total']);
		return $total;
	}



/**
 * Returns member's declined cashback
 * @return	string	member's declined cashback
*/


	public function GetDeclinedBalance()
	{
		global $userid;
		$result = smart_mysql_query("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND status='declined'");
		$row = mysqli_fetch_array($result);
		$total = DisplayMoney($row['total']);
		return $total;
	}



/**
 * Returns member's lifetime cashback
 * @return	string	member's lifetime cashback
*/


	public function GetLifetimeCashback()
	{
		global $userid;
		// all confirmed payments
		$row = mysqli_fetch_array(smart_mysql_query("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND status='".Transaction::STATUS_CONFIRMED."'"));
		// "paid" payments
		$row2 = mysqli_fetch_array(smart_mysql_query("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND status='".Transaction::STATUS_PAID."'"));
		$total = $row['total'] - $row2['total'];
		$total = DisplayMoney($total);
		return $total;
	}



/**
 * Returns cash out requested for member
 * @return	string	requested cash value
*/


	public function GetCashOutRequested()
	{
		global $userid;
		$result = smart_mysql_query("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND status='request'");
		$row = mysqli_fetch_array($result);
		$total = DisplayMoney($row['total']);
		return $total;
	}



/**
 * Returns cash out processed for member
 * @return	string	cash out processed value
*/


	public function GetCashOutProcessed()
	{
		global $userid;
		$result = smart_mysql_query("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)$userid."' AND status='".Transaction::STATUS_PAID."'");
		$row = mysqli_fetch_array($result);
		$total = DisplayMoney($row['total']);
		return $total;
	}



/**
 * Returns total of new member's messages from administrator
 * @return	integer		total of new messages for member from administrator
*/


	public function GetMemberMessagesTotal()
	{
		$userid	= $_SESSION['userid'];
		$result = smart_mysql_query("SELECT COUNT(*) AS total FROM cashbackengine_messages_answers WHERE user_id='".(int)$userid."' AND is_admin='1' AND viewed='0'");
		$row = mysqli_fetch_array($result);

		if ($row['total'] == 0)
		{
			$result = smart_mysql_query("SELECT COUNT(*) AS total FROM cashbackengine_messages WHERE user_id='".(int)$userid."' AND is_admin='1' AND viewed='0'");
			$row = mysqli_fetch_array($result);
		}
		return (int)$row['total'];
	}
    public function userNotifications(Request $request){
        $notification = UserNotification::filter($request)->get();
        return $this->showAll($notification);
    }
    public function deleteSingleNotifications(Request $request,$id){
        $notification = UserNotification::where('id',$id)->update(['seen'=> 1]);
        return response()->json([
            'data' => $notification,
            'message' => __('Notification deleted Successfully'),
            'success' => true
        ]);
    }
    public function deleteAllNotifications(Request $request){
        $notification = UserNotification::filter($request)->update(['seen'=> 1]);
        return response()->json([
            'data' => $notification,
            'message' => __('Notifications deleted Successfully'),
            'success' => true
        ]);
    }




}
