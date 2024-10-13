<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Coupon;

class CouponTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
     //   'coupons'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Coupon $coupon)
    {
        return [
            'identifier' => (int) $coupon->coupon_id,
            'autoLinkID' =>(string)	$coupon->link_id,

            'offerType' =>	(string) $coupon->coupon_type,
            'title' =>(string)	$coupon->title,
            'couponCode' =>(string)	$coupon->code,
            'redirectURL' =>(string)	$coupon->link,

            'description' =>(string)	$coupon->description,
            'exclusive' =>(string)	$coupon->exclusive,
            'NoOfLikes' =>(int)	$coupon->likes,
            'NoOfTodayVisits' =>(int)	$coupon->visits_today,
            'NoOfVisits' =>	(int)$coupon->visits,
            'sortOrder' =>	(int)$coupon->sort_order,
            'viewed' =>	(int)$coupon->viewed,
            'status' =>(string)	$coupon->status,

            'validFrom' =>(string)	$coupon->start_date,
            'validTo' =>(string)	$coupon->end_date,
            'addedOnDate' =>(string)	$coupon->added,
            'lastVisitedOnDate' =>	(string)$coupon->last_visit,
            'offerTypeText' =>	(string)$coupon->offer_type_text,
      

        ];
    }

    public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'coupon_id',
            'autoLinkID' =>	'link_id',

            'offerType' =>	'coupon_type',
            'title' =>	'title',
            'coupoCode' =>	'code',
            'redirectURL' =>	'link',

            'description' =>	'description',
            'exclusive' =>	'exclusive',
            'NoOfLikes' =>	'likes',
            'NoOfTodayVisits' =>	'visits_today',
            'NoOfVisits' =>	'visits',
            'sortOrder' =>	'sort_order',
            'viewed' =>	'viewed',
            'status' =>	'status',

            'validFrom' =>	'start_date',
            'validTo' =>	'end_date',
            'addedOnDate' =>	'added',
            'lastVisitedOnDate' =>	'last_visit',
            'offerTypeText' => 'offer_type_text',


            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
