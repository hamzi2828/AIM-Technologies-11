<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AppdomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //INSERT INTO `appdomains` (`id`, `apidomain`, `label`, `country_code2`, `country_code3`, `langcode`, `iconpath`) VALUES (NULL, 'mobileapi.apopou.gr', 'Ελλάδα', 'GR', 'GRE', 'EL', 'https://apopou.gr/images/greece.jpg'), (NULL, 'mobileapi.apopou.com.cy', 'Κύπρος', 'CY', 'CYP', 'EL', 'https://apopou.gr/images/greece.jpg');

    DB::table('appdomains')->insert(

        ['apidomain' => 'mobileapi.apopou.gr',
        'label' => 'Ελλάδα',
        'country_code2' => 'GR',
        'country_code3' => 'GRE',
        'langcode' => 'EL',
        'iconpath' => 'https://apopou.gr/images/greece.jpg',
        'cid' =>83]
     );

      DB::table('appdomains')->insert(
        ['apidomain' => 'mobileapi.apopou.com.cy',
        'label' => 'Κύπρος',
        'country_code2' => 'CY',
        'country_code3' => 'CYP',
        'langcode' => 'EL',
        'iconpath' => 'https://apopou.gr/images/cyprus.jpg',
        'cid' =>56]
     );

    }
}
