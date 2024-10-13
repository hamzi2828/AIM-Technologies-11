<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    public $timestamps = false;
    protected $table= 'appsettings';
    protected $dateFormat = 'Y-m-d H:m:s';
    //use SoftDeletes;
    protected $dates = ['created_at'];
    protected $fillable = [
        'setting_key',
        'setting_value'
    ];

}
