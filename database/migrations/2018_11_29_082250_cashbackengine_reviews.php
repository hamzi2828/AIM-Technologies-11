<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  
        Schema::dropIfExists('cashbackengine_reviews');
          Schema::create('cashbackengine_reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->Integer('retailer_id')->default(0);
            $table->Integer('user_id')->default(0);
            $table->string('review_title',255)->nullable();
            
            $table->tinyInteger('rating')->default(0);
           
            $table->text('review')->nullable();
            
           
            $table->enum('status', ['active','pending' ,'inactive'])->default('active');
            $table->dateTime('added')->default(\DB::raw('CURRENT_TIMESTAMP(0)'));
            $table->dateTime('updated')->nullable();
            
          });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbackengine_reviews');
    }
}