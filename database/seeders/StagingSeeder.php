<?php

use Illuminate\Database\Seeder;

class StagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run() {
     // Connect to production database    
     
     //source: https://medium.com/@ryanlebel/copy-production-database-data-to-staging-database-with-only-a-laravel-seed-d0d08b08dd6c
     
 /*    
     $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('batchinfo')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('batchinfo')->insert((array) $data);
     }
   */
   /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_affnetworks')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_affnetworks')->insert((array) $data);
     }
     */  
       
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_categories')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_categories')->insert((array) $data);
     }
     
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_clickhistory')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_clickhistory')->insert((array) $data);
     }
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_content')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_content')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_countries')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_countries')->insert((array) $data);
     }
     */
        $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_coupons')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_coupons')->insert((array) $data);
     }
    /*   
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_coupon_categories')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_coupon_categories')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_coupon_to_category')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_coupon_to_category')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_email_templates')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_email_templates')->insert((array) $data);
     }
     */
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_favorites')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_favorites')->insert((array) $data);
     }
     /*
        $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_invitations')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_invitations')->insert((array) $data);
     }
       */
       /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_languages')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_languages')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_messages')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_messages')->insert((array) $data);
     }
     */
     /*
     $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_messages_answers')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('batchinfo')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_messages_answers')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('batchinfo')->insert((array) $data);
     }
     */
    /*
        $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_reports')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_reports')->insert((array) $data);
     }
      */ 
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_retailers')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_retailers')->insert((array) $data);
     }
     
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_retailer_to_category')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_retailer_to_category')->insert((array) $data);
     }
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_not_recorded')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_not_recorded')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_retailer_to_country')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_retailer_to_country')->insert((array) $data);
     }
     */
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_reviews')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_reviews')->insert((array) $data);
     }
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_settings')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_settings')->insert((array) $data);
     }
     */
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_transactions')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_transactions')->insert((array) $data);
     }
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_users')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_users')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('failed_jobs')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('failed_jobs')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('ip_ranges_cy')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('ip_ranges_cy')->insert((array) $data);
     }
     */
     /*
       $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('jobs')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('jobs')->insert((array) $data);
     }
     */
     /*
     $live_database = DB::connection('mysql');
     // Get table data from production
     foreach($live_database->table('cashbackengine_retailerscommissions')->get() as $data){
        // Save data to staging database - default db connection
        DB::table('cashbackengine_retailerscommissions')->insert((array) $data);
     }
*/
  }
}