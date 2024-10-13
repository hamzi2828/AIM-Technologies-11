<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineFavorites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cashbackengine_favorites');
          Schema::create('cashbackengine_favorites', function (Blueprint $table) {
            $table->increments('favorite_id');
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('retailer_id')->default(0);
            
            $table->dateTime('added')->nullable();
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
        Schema::dropIfExists('cashbackengine_favorites');
    }
}