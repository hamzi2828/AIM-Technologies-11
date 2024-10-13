<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileVisitsCashbackengineRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbackengine_retailers', function (Blueprint $table) {
            $table->unsignedInteger('mobile_visits')->default(0);
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
            $table->dropColumn('mobile_visits');
        });
    }
}
