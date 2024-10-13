<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
  {
        Schema::dropIfExists('cashbackengine_users');
          Schema::create('cashbackengine_users', function (Blueprint $table) {
              
            $table->increments('user_id');
          
            $table->string('username',70)->default('');
            $table->string('password',32)->default('');
            $table->string('email',100)->default('');
            
              $table->string('fname',128)->default('');
            $table->string('lname',25)->default('');
            $table->string('gender',10)->default('');
            
            $table->string('address',32)->default('');
            $table->string('address2',70)->default('');
            $table->string('city',50)->default('');
            
            $table->string('state',50)->default('');
            $table->string('zip',10)->default('');
            $table->Integer('country')->default(0);
            
            $table->string('phone',20)->default('');
            $table->string('payment_method',50)->default('');
            $table->string('reg_source',100)->default('');
            
            $table->unsignedInteger('ref_clicks')->default(0);
             $table->unsignedInteger('ref_id')->default(0);
            $table->tinyInteger('ref_bonus')->default(0);
            $table->tinyInteger('newsletter')->default(0);
            
            $table->string('ip',15)->default('');
            
           
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            $table->string('auth_provider',100)->default('');
            $table->string('auth_uid',50)->default('');
            $table->string('activation_key',100)->default('');
            $table->string('unsubscribe_key',100)->default('');
            
            $table->string('login_session',255)->default('');
            $table->dateTime('last_login')->nullable();
            $table->unsignedInteger('login_count')->default(0);
            $table->string('last_ip',15)->default('');
            $table->dateTime('created')->default(\DB::raw('CURRENT_TIMESTAMP(0)'));
            $table->text('block_reason')->nullable();
            $table->tinyInteger('validated')->default(0);
            $table->tinyInteger('sha1')->default(1);
            
          });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbackengine_users');
    }
}