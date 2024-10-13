<?php
namespace App\Models;

use App\Models\Retailercategory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\RetailerScope;
//use App\Traits\Slugify;
use App\Transformers\RetailerTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;
use Overtrue\LaravelFavorite\Traits\Favoriteable;


class Retailer extends Model
{
  //  use Slugify;
      use Favoriteable;

    public $timestamps = false;
    protected $table = 'cashbackengine_retailers';
    protected $dateFormat = 'Y-m-d H:m:s';   // examples 2018-09-30 18:36:35, 2012-08-28 10:38:07 , 2018-10-02 12:09:27
    protected $primaryKey = 'retailer_id';
    //protected $appends = ['apopoulink','couponstotal']; commented for now by Nasir

    const CREATED_AT = 'added';
    const FEATURED_RETAILER = '1';
    const NOT_FEATURED_RETAILER = '0';
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const EXPIRED = 'expired';
    const STORE_OF_WEEK = '1';

    public $transformer = RetailerTransformer::class;

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new RetailerScope);
    }

    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

     public function coupons()
    {
        return $this->hasMany(Coupon::class,'retailer_id');
    }

     public function products()
    {
        return $this->hasMany('App\Models\Product','programid','program_id');
    }


    public function getApopoulinkAttribute(){
        //https://apopou.gr/kouponia/notino/379#undefined
 //       return "https://apopou.gr/kouponia/". $this->getSlug($this->title)."/".$this->retailer_id."#undefined";
 return "https://apopou.gr/kouponia/";
    }

  /*  public function getCouponstotalAttribute(){
        return $this->getCouponsCountAttribute();
    }
    */
    public function getCashbackAttribute(){
        $cashback = $this->attributes['cashback'];
        if(isset($cashback[0]) && $cashback[0]=='-'){
            $cashback = ltrim($cashback, '-');
            return "Έως ".$cashback;

        } else if( isset($cashback[0]) && $cashback[0]=='0') {
            return "Ν/Α";
        }
        return $cashback;
    }
    public function getUserId($token){
        if($token){
            $tokend = PersonalAccessToken::findToken($token);
            if($tokend && $tokend->tokenable()){
                return $user_id = $tokend->tokenable->user_id;
            }
        }
        return false;
    }
    public function getUrlAttribute()
    {
        $userId = $this->getUserId(\request()->bearerToken());
        if($userId){
            return str_replace("%7BUSERID%7D",$userId,$this->attributes['url']);
        }
        return $this->attributes['url'];
    }

    public function getImageAttribute(){
        $main_domain = explode(".",env('APP_URL'),2);
        return "https://{$main_domain[1]}/img/stores/{$this->attributes['image']}";

    }

    public function categories() {
            return $this->belongsToMany(Retailercategory::class, 'cashbackengine_retailer_to_category', 'retailer_id', 'category_id');

    }
    public function favoritess() {
        return $this->hasMany(Favorite::class, 'retailer_id');

    }
      /*
    private function getCouponsCountAttribute(){
        return $this->coupons()->count();
    }
    */
/*     public function scopeActive($query)
    {
        $query->where('status', Retailer::ACTIVE);
    }
*/
    public function scopeFilter($query, $request)
    {
        if ( isset($request->search) && trim($request->search !== '') ) {
            $query->where('title', 'LIKE', '%'. trim($request->search) . '%');
        }
        return $query;
    }
    /*
    public function getTitleAttribute() {
        return strtoupper($this->attributes['title']);
    }
    */

}
