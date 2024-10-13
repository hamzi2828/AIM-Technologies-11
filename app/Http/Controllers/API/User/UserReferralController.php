<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\ApiController;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserReferralController extends ApiController
{
    public function __construct(){
        //$this->middleware('can:view,user')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {

       $refTotalClicks = $this->GetRefClicksTotalAPI();
       $refTotal = $this->GetReferralsTotalAPI();
       $refPendingBonuses = $this->GetReferralsPendingBonusesAPI();
       $refPaidBonuses = $this->GetReferralsPaidBonusesAPI();

        //$referrals = 1;
        return response()->json(['success' => 'true','refTotalClicks' => $refTotalClicks,'refTotal' => $refTotal,'refPendingBonuses' =>$refPendingBonuses,'refPaidBonuses' => $refPaidBonuses]);
        //return $this->showAll($transactions);
    }


  /**
 * Returns member's ref link clicks
 * @param	$userid		User ID
 * @return	string		ref link clicks total
*/
    public function GetRefClicksTotalAPI()
    {
        $result = DB::select("SELECT ref_clicks AS total FROM cashbackengine_users WHERE user_id = '".(int)auth('sanctum')->user()->user_id."' LIMIT 1");
        if($result > 0){
            if($result[0]->total){
                return $result[0]->total;
            }
        }
        return 0;
    }
	/**
 * Returns member's referrals total
 * @param	$userid		User's ID
 * @return	string		member's referrals total
*/
    public function GetReferralsTotalAPI()
    {
        $result = DB::select("SELECT COUNT(*) AS total FROM cashbackengine_users WHERE ref_id = '".(int)auth('sanctum')->user()->user_id."' AND ref_id>=20000");
        if($result > 0){
            if($result[0]->total){
                return $result[0]->total;
            }
        }
        return 0;
    }
	/**
 * Returns member's ref pending bonuses
 * @param	$userid		User ID
 * @return	string		ref pending bonuses
*/
    public function GetReferralsPendingBonusesAPI()
    {
        $result = DB::select("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)auth('sanctum')->user()->user_id."' AND payment_type='friend_bonus' AND status='pending'");
        if($result > 0){
            if($result[0]->total){
                return $result[0]->total;
            }
        }
        return 0;
    }
	/**
 * Returns member's ref paid bonuses
 * @param	$userid		User ID
 * @return	string		ref paid bonuses
*/

	public	function GetReferralsPaidBonusesAPI()
	{
        $result = DB::select("SELECT SUM(amount) AS total FROM cashbackengine_transactions WHERE user_id='".(int)auth('sanctum')->user()->user_id."' AND payment_type='friend_bonus' AND status='confirmed'");
        if($result > 0){
            if($result[0]->total){
                return $result[0]->total;
            }
        }
        return 0;
	}
}
