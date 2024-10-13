<?php


namespace App\Models;


use App\Transformers\NotificationTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserNotification extends Model
{
     use HasFactory;
    public $timestamps = false;
    protected $table= 'notifications';
    protected $dateFormat = 'Y-m-d H:m:s';
    //use SoftDeletes;
    protected $dates = ['created_at'];
    public $transformer = NotificationTransformer::class;
    protected $fillable = [
        'user_id',
        'title',
        'text',
        'seen',
    ];
    public static function scopeFilter($query, $request)
    {
        return $query->where('user_id', ($request->user()->user_id))->where('seen',0);
    }

     public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

}
