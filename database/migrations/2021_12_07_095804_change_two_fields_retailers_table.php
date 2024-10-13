<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTwoFieldsRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbackengine_retailers', function (Blueprint $table) {
        $table->string('program_id',255)->index('program_id_index')->change();
        $table->string('url',512)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashbackengine_retailers', function (Blueprint $table) {
            $table->string('program_id',255);
            $table->string('url',512);
        });
    }
}
