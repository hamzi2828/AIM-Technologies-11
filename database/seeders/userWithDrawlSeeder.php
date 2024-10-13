<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userWithDrawlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cashbackengine_transactions')->insert(
            [
                'reference_id' => '2019785398A',
                'status' => 'confirmed',
                'payment_type' => 'Withdrawal',
                'amount' => 10,
                'user_id' => 51,
                'created' => now()
            ]
        );
        DB::table('cashbackengine_transactions')->insert(
            [
                'reference_id' => '2019785398A',
                'status' => 'confirmed',
                'payment_type' => 'Withdrawal',
                'amount' => 50,
                'user_id' => 51,
                'created' => now()
            ]
        );
        DB::table('cashbackengine_transactions')->insert(
            [
                'reference_id' => '2019785398A',
                'status' => 'confirmed',
                'payment_type' => 'Withdrawal',
                'amount' => 150,
                'user_id' => 51,
                'created' => now()
            ]
        );
        DB::table('cashbackengine_transactions')->insert(
            [
                'reference_id' => '2019785398A',
                'status' => 'confirmed',
                'payment_type' => 'friend_bonus',
                'amount' => 250,
                'user_id' => 51,
                'created' => now()
            ]
        );
    }
}
