<?php

namespace App\Http\Controllers\API\Retailer;

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use App\Models\Retailer;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;


class RetailerCouponController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $coupon = Coupon::with('retailers')->where('retailer_id',$request->route('retailer'))->get();
        $tokend = PersonalAccessToken::findToken($request->bearerToken());
        if($tokend && $tokend->tokenable()) {
            Session::put('userId',$tokend->tokenable->user_id);
        }
        return $this->showAll($coupon);

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
     * @param  Retailer $retailer
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
}
