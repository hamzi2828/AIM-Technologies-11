<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineRetailers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
  {
        Schema::dropIfExists('cashbackengine_retailers');
          Schema::create('cashbackengine_retailers', function (Blueprint $table) {
            $table->increments('retailer_id');
            $table->string('title',512)->default('');
            $table->Integer('network_id')->default(0);
            $table->string('program_id',255)->default('');
             $table->string('url',255)->default('');
             $table->string('image',255)->default('');
              $table->string('old_cashback',20)->default('');
               $table->string('cashback',20)->default('');
             $table->text('conditions')->nullable();
             $table->text('description')->nullable();
                $table->string('website',255)->default('');
                $table->string('retailer_url',255)->default('');
                $table->string('tags',255)->default('');
                $table->string('seo_title',1024)->default('');
         
                $table->string('meta_description',1024)->default('');
                $table->string('meta_keywords',1024)->default('');
                
                $table->dateTime('end_date')->nullable();
            
            $table->tinyInteger('featured')->default(0);
           
           $table->tinyInteger('deal_of_week')->default(0);
           
            $table->Integer('visits')->default(0);
           
            $table->enum('status', ['active', 'inactive','expired'])->default('active');
            $table->dateTime('added')->default(\DB::raw('CURRENT_TIMESTAMP(0)'));
            
          });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbackengine_retailers');
    }
}