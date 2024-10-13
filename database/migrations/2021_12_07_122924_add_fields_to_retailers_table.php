<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbackengine_retailers', function (Blueprint $table) {
            $table->char('flat_rate',4);
            $table->char('above_rate',4);
            $table->tinyInteger('ourcommission_percent');
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
            $table->char('flat_rate',4);
            $table->char('above_rate',4);
            $table->tinyInteger('ourcommission_percent');
        });
    }
}
