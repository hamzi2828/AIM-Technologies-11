<?php
namespace App\Models;

use App\Models\Retailer;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CouponScope;
//use App\Traits\Slugify;
use App\Transformers\CouponTransformer;
use App\Models\Couponcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;

class Coupon extends Model
{
  //  use Slugify;

    protected $table = 'cashbackengine_coupons';
    protected $dateFormat = 'Y-m-d H:m:s';   // examples 2018-09-30 18:36:35, 2012-08-28 10:38:07 , 2018-10-02 12:09:27
    protected $primaryKey = 'coupon_id';
  //  protected $appends = ['apopoulink','couponstotal'];
    protected $appends = ['offer_type_text']; 
    const CREATED_AT = 'added';

    public $transformer = CouponTransformer::class;

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new CouponScope);
    }



        public function getOfferTypeTextAttribute()
        {
            switch($this->attributes['coupon_type']){
                case 'cashback' : return "CASHBACK";    break;
                case 'coupon'   : return "ΚΟΥΠΟΝΙ";     break;
                case 'daily'    : return "DAILY DEALS"; break;
                case 'discount'    : return "ΠΡΟΣΦΟΡΑ";    break;
                case 'flyer'    : return "E-FLYER"; break;
                case 'printable'    : return "ΕΚΤΥΠΩΜΕΝΟ";    break;
                default: return ''; break;
            }
            
        }


    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

     public function retailers()
    {
        return $this->belongsTo(\App\Models\Retailer::class,'retailer_id');
    }


    public function getApopoulinkAttribute(){
        //https://apopou.gr/kouponia/notino/379#undefined
 //       return "https://apopou.gr/kouponia/". $this->getSlug($this->title)."/".$this->retailer_id."#undefined";
 return "https://apopou.gr/kouponia/";
    }

    public function getCouponstotalAttribute(){
        return $this->getCouponsCountAttribute();
    }

    public function getCashbackAttribute(){
        $cashback = $this->attributes['cashback'];
        if($cashback[0]=='-'){
            $cashback = ltrim($cashback, ' - ');
            return "Έως ".$cashback;

        } else if($cashback[0]=='0') {
            return "Ν/Α";
        }
        return $cashback;
    }

    public function getImageAttribute(){
        return "https://apopou.gr/img/stores/{$this->attributes['image']}";

    }


    public function getEndDateAttribute(){
       
       return (int) substr($this->attributes['end_date'],0,4) < 3000 ?$this->attributes['end_date']:"-";
    }

    private function getCouponsCountAttribute(){
        return $this->coupons()->count();
    }
    public function getLinkAttribute()
    {
        if(Session::get('userId')){
            if(!empty($this->attributes['link'])){
                return str_replace("%7BUSERID%7D",Session::get('userId'),$this->attributes['link']);
            }
            return str_replace("%7BUSERID%7D",Session::get('userId'),$this->retailers->url);
        }
        if(Session::has('userId'))
        {
            Session::forget('userId');
        }
        return $this->attributes['link'] ? $this->attributes['link']  : $this->retailers->url;
    }


}
