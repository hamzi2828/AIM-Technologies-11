<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AppsettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('appsettings')->insert(
       ['setting_key' => 'forgot_url',
        'setting_value' => 'https://apopou.gr/forgot_mobile',
        ]
     );
     
      DB::table('appsettings')->insert(
       ['setting_key' => 'not_recorded_embed',
        'setting_value' =>  '<!-- Easy Forms -->\r\n<div id=\"c10\">\r\n    Fill out my <a href=\"https://forms.apopou.gr/app/form?id=10\">online form</a>.\r\n</div>\r\n<script type=\"text/javascript\">\r\n    (function(d, t) {\r\n        var s = d.createElement(t), options = {\r\n            \'id\': 10,\r\n            \'theme\': 0,\r\n            \'container\': \'c10\',\r\n            \'height\': \'1426px\',\r\n            \'form\': \'//forms.apopou.gr/app/embed\'\r\n        };\r\n        s.type= \'text/javascript\';\r\n        s.src = \'https://forms.apopou.gr/static_files/js/form.widget.js\';\r\n        s.onload = s.onreadystatechange = function() {\r\n            var rs = this.readyState; if (rs) if (rs != \'complete\') if (rs != \'loaded\') return;\r\n            try { (new EasyForms()).initialize(options).display() } catch (e) { }\r\n        };\r\n        var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);\r\n    })(document, \'script\');\r\n</script>\r\n<!-- End Easy Forms -->',
        ]
     );

     DB::table('appsettings')->insert(
       ['setting_key' => 'forgot_url',
        'setting_value' => 'https://apopou.gr/forgot_mobile',
        ]
     );
     
     DB::table('appsettings')->insert(
       ['setting_key' => 'help_url',
        'setting_value' => 'https://apopou.gr/help',
        ]
     );
     
     DB::table('appsettings')->insert(
       ['setting_key' => 'refer_credit',
        'setting_value' => '2.5',
        ]
     );
     
       DB::table('appsettings')->insert(
       ['setting_key' => 'currency',
        'setting_value' => '€',
        ]
     );
     
     DB::table('appsettings')->insert(
       ['setting_key' => 'validate_refer_credit',
        'setting_value' => '5',
        ]
     );
     
      DB::table('appsettings')->insert(
       ['setting_key' => 'min_payout',
        'setting_value' => '20',
        ]
     );
     
      DB::table('appsettings')->insert(
       ['setting_key' => 'yearly_maintenance_fee',
        'setting_value' => '9',
        ]
     );
     
       DB::table('appsettings')->insert(
       ['setting_key' => 'ref_url',
        'setting_value' => 'https://apopou.gr/?ref=',
        ]
     );
    
     DB::table('appsettings')->insert(
       ['setting_key' => 'refer_friend_terms_url',
        'setting_value' => 'https://apopou.gr/blog',
        ]
     );
     
     
       DB::table('appsettings')->insert(
       ['setting_key' => 'premium',
        'setting_value' => '2.99',
        ]
     );
    }
}
