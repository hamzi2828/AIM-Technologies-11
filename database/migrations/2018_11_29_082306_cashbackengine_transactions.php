<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbackengineTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   {
        Schema::dropIfExists('cashbackengine_transactions');
          Schema::create('cashbackengine_transactions', function (Blueprint $table) {
            $table->increments('transaction_id');
           
            $table->string('reference_id',50);
            
            $table->Integer('network_id')->default(0);
            $table->Integer('retailer_id')->default(0);
            
            $table->string('retailer',100)->default('');
            $table->string('program_id',100)->default(0);
            $table->Integer('user_id')->default(0);
            $table->Integer('ref_id')->default(0);
            $table->string('payment_type',50);
            $table->Integer('payment_method')->default(0);
            $table->text('payment_details')->nullable();
            $table->decimal('transaction_amount')->default(0.0000);
            $table->decimal('transaction_commision')->default(0.0000);
             $table->decimal('amount',15,4);
            
           
            $table->enum('status', ['confirmed','pending','declined','paid','request','unknown']);
            $table->text('reason')->nullable();
            $table->tinyInteger('notification_sent')->default(0);
            $table->dateTime('created')->default(\DB::raw('CURRENT_TIMESTAMP(0)'));
            $table->dateTime('updated')->nullable();
            $table->dateTime('process_date')->nullable();
            
          });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbackengine_transactions');
    }
}