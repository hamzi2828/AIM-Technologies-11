<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\Click;
use App\Models\Retailer;
use App\Models\Favorite;
use App\Models\Product;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use App\Scopes\UserScope;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Favoriter;

    public $timestamps = false;
    const CREATED_AT = 'created';
    const VALIDATED_USER = '1';
    const NOT_VALIDATED_USER = '0';
    const ACTIVE='active';
    const INACTIVE = 'inactive';

    protected $table = 'cashbackengine_users';
    protected $dateFormat = 'Y-m-d H:m:s';   // examples 2018-09-30 18:36:35, 2012-08-28 10:38:07 , 2018-10-02 12:09:27
    protected $primaryKey = 'user_id';

    const UPDATED_AT = 'updated_at';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'activation_key',
        'phone',
        'ref_id',
        'fname',
        'password',
        'sha1',
        'country',
        'ip',
        'last_ip',
        'last_login',
        'last_device',
        'login_count',
        'reg_source'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
      //  'remember_token',
        'activation_key'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
      //  'email_verified_at' => 'datetime',
    ];

    public $transformer = UserTransformer::class;

     protected static function boot(){
        parent::boot();
        static::addGlobalScope(new UserScope);
    }

     /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->username;
    }

    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

    public function isVerified() {
        return $this->verified == User::VALIDATED_USER;
    }

     public function generateActivationKey() {
        return User::generateKey($this->username);
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction','user_id');
    }
    public function country(){
        return $this->belongsTo(AppDomains::class);
    }

    public function clicks(){
        return $this->hasMany(Click::class,'user_id');
    }

   /**
     * Returns random key taken from cashbackengine scrip
     * @param	$text		string
     * @return	string		random key for user verification
    */
    public static	function generateKey($text)
	{
		$text = preg_replace("/[^0-9a-zA-Z]/", " ", $text);
		$text = substr(trim($text), 0, 50);
		$key = md5(time().$text.mt_rand(1000,9999));
		return $key;
	}


    public static function generateVerificationCode()
    {
        return Str::random(40);
    }


     public function favoriteRetailers()
    {
        return $this->belongsToMany(Retailer::class, Favorite::class, 'user_id', 'retailer_id');//->where('favoriteable_type', '=', FAVORITE::RETAILER);
    }

     public function favoriteProducts()
    {
            $database = $this->getConnection()->getDatabaseName();
            return $this->belongsToMany(Product::class, "$database.cashbackengine_favorites", 'user_id', 'favoriteable_id')->where('favoriteable_type', '=', FAVORITE::PRODUCT);
}

      /*public function getEmailAttribute(){
        if(isset($this->email)){
            return $this->email == "" ? $this->username : $this->email;
        }
        return '';
      }*/

}
