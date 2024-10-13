<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTwoFieldsToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbackengine_transactions', function (Blueprint $table) {
            $table->decimal('amount',17,2)->change();
             $table->decimal('transaction_commision',15,4)->change();
             $table->decimal('transaction_amount',15,4)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashbackengine_transactions', function (Blueprint $table) {
            $table->decimal('amount',15,4);
             $table->decimal('transaction_commision',15,4);
              $table->decimal('transaction_amount',15,4);
        });
    }
}
