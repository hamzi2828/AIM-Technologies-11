<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Retailercategory;


class RetailercategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
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
        public function transform(Retailercategory $category)
    {
        return [
            'identifier' => (int) $category->category_id,
            'parentID' => 	(string) $category->parent_id,
            'categoryTitle' => (string) $category->name,
            'IMG' => 	(string) $category->img,
            'ICO' => 	(string) $category->icon,

          //  'categoryDescription' => 	(string) $category->description,
            'URI' =>(string) $category->category_url,
          //  'headTitle' => 	(string) $category->meta_keywords,
         //   'metaDescription' =>(string) $category->meta_description,

            'sortNo' => 	(string) $category->sort_order,
            'sucategories' => 	 $category->relationLoaded('subCategories') ? $category->subCategories : '',
        ];
    }

    public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'category_id',
            'parentID' => 	'parent_id',
            'categoryTitle' => 'name',
        //    'categoryDescription' => 	'description',
            'ICO' => 	'icon',
            'IMG' => 	'img',

            'URI' => 	'category_url',
         //   'headTitle' => 	'meta_keywords',
         //   'metaDescription' => 	'meta_description',

            'sortNo' => 	'sort_order',
   //         'sucategories' => 	'subCategories',
//            'retailers' => 	'retailers',

            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
