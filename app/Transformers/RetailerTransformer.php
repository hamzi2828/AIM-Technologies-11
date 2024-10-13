<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Retailer;

class RetailerTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
       // 'coupons'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'coupons','categories'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Retailer $retailer)
    {
         return $this->filterFields([
            'identifier' => (int) $retailer->retailer_id,
            'networkID' => 	(int) $retailer->network_id,
            'networkProgramID' =>	(string) $retailer->program_id,

            'storeName' => (string) $retailer->title,
            'redirectURL' => (string) $retailer->url,
            'storeImgURL' => (string) $retailer->image,
            'storeCashback'=> (string) $retailer->cashback,
         //   'old_cashback'	=> (int) $retailer->old_cashback,
            'storeTerms'	=> (string) $retailer->conditions,
            'shortDescription'	=>(string) $retailer->description,
            'storeDomain'	=>(string) $retailer->website,
         //   'storeURL'	=>(string) $retailer->retailer_url,
            'storeTags'	=>(string) $retailer->tags,
            'headTitle'	=>(string) $retailer->seo_title,
            'metaDescription'=>	(string) $retailer->meta_description,
            'shippingInfo'=>	(string) $retailer->meta_keywords,

            'featuredStore'=>(int)	$retailer->featured,
            'storeOfWeek'=>(int)	$retailer->deal_of_week,
            'noOfVisits'=>(int)	$retailer->visits,
            'mobileVisits'=>(int)	$retailer->mobile_visits,
            'status'=>(string)	$retailer->status,
            'favoriters'=>(int)	request()->bearerToken() && $retailer->favoritess ? count($retailer->favoritess) : 0,

            'flatShippingAmount'=>(double) $retailer->flat_rate,
            'aboveFlatShippingAmount'=>(double)	$retailer->above_rate,
            'apopouCommissionPercent'=> (int)	$retailer->ourcommission_percent,

             'expiringDate'=>(string)	$retailer->end_date,
             'createdOnDate'=>(string)	$retailer->added,
             'coupons_count' => (int) count($retailer->coupons),
             'products_count' => (int) $retailer->products_count,
        ]);
    }

    public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'retailer_id',
            'networkID' => 	'network_id',
            'networkProgramID' =>	'program_id',

            'storeName' => 'title',
            'redirectURL' => 'url',
            'storeImgURL' => 'image',
            'storeCashback'=> 'cashback',
         //   'old_cashback'	=> 'old_cashback',
            'storeTerms'	=> 'conditions',
            'shortDescription'	=>'description',
            'storeDomain'	=>'website',
          //  'storeURL'	=>'retailer_url',
            'storeTags'	=>'tags',
            'headTitle'	=>'seo_title',
            'metaDescription'=>	'meta_description',
            'shippingInfo'=>	'meta_keywords',

            'featuredStore'=>	'featured',
            'storeOfWeek'=>	'deal_of_week',
            'noOfVisits'=>	'visits',
            'mobileVisits'=>	'mobile_visits',
            'status'=>	'status',

            'flatShippingAmount'=>	'flat_rate',
            'aboveFlatShippingAmount'=>	'above_rate',
            'apopouCommissionPercent'=>	'ourcommission_percent',

             'expiringDate'=>	'end_date',
             'createdOnDate'=>	'added',
                'coupons_count'  => 'coupons_count' ,
                'products_count' => 'products_count',

            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public function includeCoupons(Retailer $retailer)
    {
        $coupons = $retailer->coupons;
        return $this->collection($coupons, new CouponTransformer);
    }

      public function includeCategories(Retailer $retailer)
    {
        $categories = $retailer->categories;
        return $this->collection($categories, new RetailercategoryTransformer);
    }

    protected function filterFields(array $user)
    {
        $fields = isset($_GET['fields']) ? explode(',', $_GET['fields']) : array_keys($user);

        return array_intersect_key($user, array_flip((array) $fields));
    }

}
