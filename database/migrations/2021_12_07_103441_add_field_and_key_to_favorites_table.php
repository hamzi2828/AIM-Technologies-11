<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldAndKeyToFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbackengine_favorites', function (Blueprint $table) {
           // $table->enum('type', ['retailer', 'product'])->default('retailer');
            $table->morphs('favoriteable','favoritable_type_index');
          //  $table->unique(['user_id', 'retailer_id','type']);
          $table->unique(['user_id', 'favoriteable_id','favoriteable_type'],'fav_user_retailer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashbackengine_favorites', function (Blueprint $table) {
           // $table->enum('type', ['retailer', 'product']);
           $table->dropMorphs('favoriteable');
        });
    }
}
