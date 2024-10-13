<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineRetailerToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   {
        Schema::dropIfExists('cashbackengine_retailer_to_category');
          Schema::create('cashbackengine_retailer_to_category', function (Blueprint $table) {
            $table->unsignedInteger('retailer_id');
            $table->unsignedInteger('category_id');
            $table->unique(['retailer_id','category_id'],'cashbackengine_retailer_to_category_pk');
          });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbackengine_retailer_to_category');
    }
}