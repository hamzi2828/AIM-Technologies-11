<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Scopes\RetailerScope;
//use App\Traits\Slugify;
use App\Transformers\ClickTransformer;
use App\Models\User;
use App\Models\Retailer;
//use App\Models\Retailercategory;

class Click extends Model
{
  //  use Slugify;

    protected $table = 'cashbackengine_clickhistory';
    protected $dateFormat = 'Y-m-d H:m:s';   // examples 2018-09-30 18:36:35, 2012-08-28 10:38:07 , 2018-10-02 12:09:27
    protected $primaryKey = 'click_id';
//    protected $appends = ['apopoulink','couponstotal'];
    public $timestamps = false;
    const CREATED_AT = 'added';
    protected $fillable = [
        'user_id',
        'retailer_id',
        'retailer',
        'click_ref',
        'click_ip',
    ];
    public $transformer = ClickTransformer::class;

    protected static function boot(){
        parent::boot();
     //   static::addGlobalScope(new RetailerScope);
    }

   public function user(){
        return $this->belongsTo(User::class,'user_id');

   }

   public function retailer(){
        return $this->belongsTo(Retailer::class,'retailer_id');

   }



}
