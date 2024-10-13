<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Retailer;
use App\Transformers\CouponcategoryTransformer;
use App\Scopes\CouponcategoryScope;

class Couponcategory extends Model
{
    use HasFactory;

        protected $table = 'cashbackengine_coupon_categories';
     
        const FEATURED_CATEGORIES = '1';
   
        public $transformer = CouponcategoryTransformer::class;
        
        
         protected static function boot(){
            parent::boot();
            static::addGlobalScope(new CouponcategoryScope);
        }

        public function coupons() {
            return $this->belongsToMany(Retailer::class, 'cashbackengine_coupon_to_category', 'category_id', 'coupon_id');

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
