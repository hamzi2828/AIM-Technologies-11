<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Productcategory;


class ProductcategoryTransformer extends TransformerAbstract
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
        public function transform(Productcategory $category)
    {
        return [
            'identifier' => (int) $category->id,
            'parentID' => 	(string) $category->parent,
            'categoryTitle' => (string) $category->name,
        //    'IMG' => 	(string) $category->img,
        //    'ICO' => 	(string) $category->icon,
            'categoryDescription' => 	(string) $category->description,
        //    'sortNo' => 	(string) $category->sort_order,
        ];
    }
    
    public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'id',
            'parentID' => 	'parent',
            'categoryTitle' => 'name',
            'categoryDescription' => 	'description',
          //  'ICO' => 	'icon',
        //    'IMG' => 	'img',
         //   'sortNo' => 	'sort_order',

            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    
    //this will hide the attribute for example in the api errors
  /*  public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'parent' => 'parentID',
            'name' => 'categoryTitle',
            'description' => 'categoryDescription',
            'icon' => 'ICO',
            'img' => 'IMG',
            'sort_order' => 'sortNo',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
   */
}
