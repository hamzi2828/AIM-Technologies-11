<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineClickhistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('cashbackengine_clickhistory');
          Schema::create('cashbackengine_clickhistory', function (Blueprint $table) {
            $table->increments('click_id');
            $table->string('click_ref',50);
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('retailer_id')->default(0);
            $table->string('retailer',255);
            $table->string('click_ip',15);
            $table->dateTime('added')->nullable();
            
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
        Schema::dropIfExists('cashbackengine_clickhistory');
    }
}