<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();

        $users = array(
                ['first_name' => 'Hamid','last_name' => 'Sardar', 'email' => 'coolsardarhamid@gmail.com', 'password' => Hash::make('secret')],
                ['first_name' => 'Chris','last_name' => 'Sevilleja', 'email' => 'chris@scotch.io', 'password' => Hash::make('secret')],
                ['first_name' => 'Holly','last_name' => 'Lloyd', 'email' => 'holly@scotch.io', 'password' => Hash::make('secret')],
                ['first_name' => 'Adnan','last_name' => 'Kukic', 'email' => 'adnan@scotch.io', 'password' => Hash::make('secret')],
        );
            
        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }

        DB::table('receipts')->delete();

        $receipts = array(
                ['customer_id' => 1, 'date' => '2015-01-12', 'total_products' => 2, 'total_amount' => 10.23, 'status'=>'inserted', 'address'=>'', 'store_id'=>1, 'tax'=>2.01, 'image_url'=>'/public/images/receipts/2016-01-07(Receipt_no).jpg'],
                ['customer_id' => 2, 'date' => '2015-09-04', 'total_products' => 3, 'total_amount' => 59.65, 'status'=>'inserted', 'address'=>'', 'store_id'=>2, 'tax'=>1.02, 'image_url'=>'/public/images/receipts/2016-01-07(Receipt_yes).jpg'],
                ['customer_id' => 1, 'date' => '2015-11-21', 'total_products' => 7, 'total_amount' => 23.78, 'status'=>'updated', 'address'=>'', 'store_id'=>3, 'tax'=>3.01, 'image_url'=>'/public/images/receipts/sample_1.jpg'],
                ['customer_id' => 3, 'date' => '2015-03-09', 'total_products' => 1, 'total_amount' => 534.78, 'status'=>'updated', 'address'=>'', 'store_id'=>4, 'tax'=>4.00, 'image_url'=>'/public/images/receipts/sample_2.jpg'],
                ['customer_id' => 1, 'date' => '2015-11-21', 'total_products' => 7, 'total_amount' => 23.78, 'status'=>'updated', 'address'=>'', 'store_id'=>3, 'tax'=>3.01, 'image_url'=>'/public/images/receipts/sample_3.jpg'],
                ['customer_id' => 1, 'date' => '2015-03-09', 'total_products' => 1, 'total_amount' => 534.78, 'status'=>'updated', 'address'=>'', 'store_id'=>4, 'tax'=>4.00, 'image_url'=>'/public/images/receipts/sample_4.jpg']
        );
        Model::reguard();
    }
}
