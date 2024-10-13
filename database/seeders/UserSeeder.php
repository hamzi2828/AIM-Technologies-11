<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'fname' => 'Hardik',
             'lname' => 'Hardik2',
            'username' => 'admin@gmail.com',
            'password' => md5(sha1('123456')),
        ]);
    }
}
