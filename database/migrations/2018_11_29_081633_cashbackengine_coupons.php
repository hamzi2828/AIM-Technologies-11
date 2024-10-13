<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
     {
      //  Schema::dropIfExists('cashbackengine_coupons');
          Schema::create('cashbackengine_coupons', function (Blueprint $table) {
            $table->increments('coupon_id');
            $table->Integer('retailer_id')->default(0);
            $table->Integer('user_id')->default(0);
            $table->string('coupon_type',10);
            $table->string('title',512);
            $table->string('code',255)->nullable();
            $table->string('link',255)->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->Text('description')->nullable();
            $table->tinyInteger('exclusive')->default(0);
            $table->Integer('likes')->default(0);
            $table->Integer('visits_today')->default(0);
            $table->Integer('visits')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->tinyInteger('viewed')->default(1);
            
            
            
            $table->enum('status', ['active', 'inactive','expired'])->default('active');
            
            $table->dateTime('added');
           $table->dateTime('last_visit')->nullable();
           $table->Integer('link_id');
           // $table->timestamps();
          });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbackengine_coupons');
    }
}