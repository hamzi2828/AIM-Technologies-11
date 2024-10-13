<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Retailer;
use App\Transformers\ProductcategoryTransformer;


class Productcategory extends Model
{
    use HasFactory;
    
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
     
        public function getParentKeyName()
    {
        return 'parent';
    }
    
        protected $connection = 'mysql_p_gr';
        protected $table = 'pt_categories_hierarchy';
        protected $primaryKey = 'id';
        
        public $transformer = ProductcategoryTransformer::class;

     /*   
        public function retailers() {
            return $this->belongsToMany(Retailer::class, 'cashbackengine_retailer_to_category', 'category_id', 'retailer_id');

        }
        */
        
    //https://laracasts.com/discuss/channels/eloquent/eloquent-getting-subcategories-from-the-categories
    public function subCategory()
    {
        return $this->belongsTo(self::class, 'parent', 'id');
    }

    public function parentCategory()
    {
        return $this->hasMany(self::class, 'id', 'parent');
    }

    /**
     * Get the comments for the blog post.
     */
    public function subCategories()
    {
        return $this->hasMany(self::class,'parent','id');
    }

 
}
