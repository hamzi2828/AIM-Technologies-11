<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Transformers\RetailerTransformer;
use App\Models\Retailer;

class Favorite extends Model
{
        //protected $connection = 'mysql';

  const CREATED_AT = 'added';
  const UPDATED_AT = 'updated';

  const RETAILER = 'retailer';
   const PRODUCT = 'product';

    protected $table = 'cashbackengine_favorites';
  //  protected $dateFormat = 'Y-m-d H:m:s';   // examples 2018-09-30 18:36:35, 2012-08-28 10:38:07 , 2018-10-02 12:09:27
    protected $primaryKey = 'favorite_id';
  //  protected $appends = ['apopoulink','couponstotal'];

    protected $fillable = [
        'user_id',
        'retailer_id',
    //    'type'
    //'favoriteable_id',
    //'favoriteable_type'
    ];
    //public $transformer = FavoriteTransformer::class;

    /*protected static function boot(){
        parent::boot();
     //   static::addGlobalScope(new RetailerScope);
    }*/

    /*public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }
    function retailors() {
        return $this->belongsTo(Retailer::class, 'retailer_id');
    }*/




}
