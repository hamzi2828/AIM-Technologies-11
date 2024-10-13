<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Retailer;
use App\Transformers\RetailercategoryTransformer;


class Retailercategory extends Model
{
    use HasFactory;

        protected $table = 'cashbackengine_categories';
        protected $primaryKey = 'category_id';
        const FEATURED_CATEGORIES = '1';
        const PARENT_CATEGORIES =0 ;
        public $transformer = RetailercategoryTransformer::class;

        public function retailers() {
            return $this->belongsToMany(Retailer::class, 'cashbackengine_retailer_to_category', 'category_id', 'retailer_id');

        }
        public function subCategories()
        {
            return $this->hasMany(self::class, 'parent_id');
        }
        public function parent_category()
        {
            return $this->hasMany(self::class, 'category_id', 'parent_id');
        }

}
