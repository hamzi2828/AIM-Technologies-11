<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appdomains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apidomain',256);
            $table->string('label',128);
            $table->string('country_code2',2);
            $table->string('country_code3',3);
            $table->string('langcode',2);
            $table->string('iconpath',256);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appdomains');
    }
}
