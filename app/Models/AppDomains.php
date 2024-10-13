<?php


namespace App\Models;


use App\Transformers\AppDomainTransformer;
use Illuminate\Database\Eloquent\Model;

class AppDomains extends Model
{
    public $timestamps = false;
    protected $table= 'appdomains';
    protected $dateFormat = 'Y-m-d H:m:s';
    public $transformer = AppDomainTransformer::class;
    //use SoftDeletes;
    protected $dates = ['created_at'];
    protected $fillable = [
        'apidomain',
        'label'
    ];
    public function user(){
        return $this->hasMany(User::class);
    }
}
