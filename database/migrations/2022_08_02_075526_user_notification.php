<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('notifications');
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('user_id');
            $table->string('title',250);
            $table->text('text');
            $table->tinyInteger('seen')->default(0);
            $table->dateTime('created_at')->default(\DB::raw('CURRENT_TIMESTAMP(0)'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
