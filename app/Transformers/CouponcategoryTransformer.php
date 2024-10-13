<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Couponcategory;

class CouponcategoryTransformer extends TransformerAbstract
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
        public function transform(Couponcategory $category)
    {
        return [
            'identifier' => (int) $category->category_id,
            'parentID'   => (string) $category->parent_id,
            'name'       => (string) $category->name,
            'img_path'   => (string) $category->icon,
            'order'      => (int) $category->sort_order

        ];
    }
    
    public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'category_id',
            'parentID' => 	'parent_id',
            'name'       => 'name',
            'img_path'   => 'icon',
            'order'      => 'sort_order'

            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
  
}
