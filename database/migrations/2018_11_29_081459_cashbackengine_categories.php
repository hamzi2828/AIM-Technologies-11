<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::dropIfExists('cashbackengine_categories');
           Schema::create('cashbackengine_categories', function (Blueprint $table) {
            $table->increments('category_id');
            $table->Integer('parent_id')->default('0');
            $table->string('name',50);
            $table->string('icon',100);
            $table->string('img',100);
            $table->text('description')->nullable()->default(NULL);
            $table->string('category_url',100);
            $table->string('meta_description',1024);
            $table->string('meta_keywords',255);
           $table->tinyInteger('sort_order')->default(0);
           
           $table->index('name');
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
        Schema::dropIfExists('cashbackengine_categories');
    }
}
