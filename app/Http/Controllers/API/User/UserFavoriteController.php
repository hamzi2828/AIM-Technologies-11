<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\ApiController;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserFavoriteController extends ApiController
{

    public function __construct() {
        $this->middleware('can:view,user')->only('index','wishlist');

    }
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $favorites = $user->favoriteRetailers;
        return $this->showAll($favorites);
    }

   public function wishlist(User $user)
    {
        $favorites = $user->favoriteProducts;
        return $this->showAll($favorites);
    }
	public function addRetailerFavorites(Request $request){
        $validationMessage = [
            'retailer_id.required' => __('validation.required' , ['attribute' => __('Reatiler Id cannot be empty.')]),
        ];
        $firstFormRules = array(
            'retailer_id' => 'required');
        $v1 = Validator::make($request->all(), $firstFormRules, $validationMessage);
        if ($v1->fails()) {
            return response()->json($v1->errors());
        }
        $favorite = new Favorite();
        $favorite->user_id = $request->user()->user_id;
        $favorite->retailer_id = $request->retailer_id;
        $favorite->save();
        return response()->json([
            'data' => $favorite,
            'success' => true,
            'message' => __('Retailer has been added to favorites')
        ]);
    }
    public function removeRetailerFavorites(Request $request){
        $validationMessage = [
            'retailer_id.required' => __('validation.required' , ['attribute' => __('Reatiler Id cannot be empty.')]),
        ];
        $firstFormRules = array(
            'retailer_id' => 'required');
        $v1 = Validator::make($request->all(), $firstFormRules, $validationMessage);
        if ($v1->fails()) {
            return response()->json($v1->errors());
        }
        $favorite = Favorite::where('user_id', $request->user()->user_id)->where('retailer_id',$request->retailer_id)->delete();
        return response()->json([
            'data' => $favorite,
            'message' => __('Retailer has been removed from favorites'),
            'success' => true
        ]);
    }
	/**
 * Returns total of users which added retialer to their favorites list
 * @return	integer		total of new messages for admin from members
*/


	public function GetFavoritesTotal(Retailer $retailer) {
		$result = smart_mysql_query("SELECT COUNT(*) AS total FROM cashbackengine_favorites WHERE retailer_id='".$retailer->retailer_id."'");
		$row = mysqli_fetch_array($result);
		return (int)$row['total'];
	}

}
