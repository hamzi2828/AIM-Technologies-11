<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProductTransformer;

class Product extends Model
{
     

    protected $connection = 'mysql_p_gr';
    
    protected $table = 'pt_products';
    public $timestamps = false;
    
        public $transformer = ProductTransformer::class;

   /* protected static function boot(){
        parent::boot();
     
    }*/   
    
     


}