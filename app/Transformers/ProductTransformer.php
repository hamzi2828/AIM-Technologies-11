<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Product;

class ProductTransformer extends TransformerAbstract
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
        
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
          'program_identifier' => 	(int) $product->id,
'retailer' => 	(string) $product->merchant,
'filename' => 	(string) $product->filename,
'productName' => 	(string) $product->name,
'description' => 	(string) $product->description,
'imageURL' => 	(string) $product->image_url,
'thumbURL' => 	(string) $product->thumb_url,
'redirectURL' => 	(string) $product->buy_url,
'price' => 	number_format((float) $product->price, 2, '.', ''),
'productCategory' => 	(string) $product->category,
'brand' => 	(string) $product->brand,
'rating' => 	(string) $product->rating,
'reviews' => 	(string) $product->reviews,
'search_name' => 	(string) $product->search_name,
'normalised_name' => 	(string) $product->normalised_name,
'original_name' => 	(string) $product->original_name,
'voucher_code' => 	(string) $product->voucher_code,
'categoryID' => 	(int) $product->categoryid,
//'dupe_hash' => 	(string) $product->dupe_hash,       //https://www.pricetapestry.com/node/2050
'ignore_regex' => 	(string) $product->ignore_regex,
'discount' => 	(int) $product->discount,
'rrp' => 	number_format((float) $product->rrp, 2, '.', ''),
'size' => 	(string) $product->size,
'color' => 	(string) $product->color,
'programID' => 	(string) $product->programid,
'currency' => 	(string) $product->currency,
'gender' => 	(string) $product->gender,
'partno' => 	(string) $product->partno,

              ];
    }
    
    public static function originalAttributes($index) {
        $attributes = [
           
           'program_identifier' => 	'id',
            'retailer' => 	'merchant',
            'filename' => 	'filename',
            'productName' => 	'name',
            'description' => 	'description',
            'imageURL' => 	'image_url',
            'thumbURL' => 	'thumb_url',
            'redirectURL' => 	'buy_url',
            'price' => 	'price',
            'productCategory' => 	'category',
            'brand' => 	'brand',
            'rating' => 	'rating',
            'reviews' => 	'reviews',
            'search_name' => 	'search_name',
            'normalised_name' => 	'normalised_name',
            'original_name' => 	'original_name',
            'voucher_code' => 	'voucher_code',
            'categoryID' => 	'categoryid',
        //    'dupe_hash' => 	'dupe_hash',      //https://www.pricetapestry.com/node/2050
            'ignore_regex' => 	'ignore_regex',
            'discount' => 	'discount',
            'rrp' => 	'rrp',
            'size' => 	'size',
            'color' => 	'color',
            'programID' => 	'programid',
            'currency' => 	'currency',
            'gender' => 	'gender',
            'partno' => 	'partno',


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
  
}
