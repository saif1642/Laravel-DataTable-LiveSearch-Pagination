<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        for ($i=0; $i < 100; $i++) { 
            DB::table('passengers')->insert([
               'name' => $faker->name,
               'email' => $faker->email,
               'contact_no' => $faker->e164PhoneNumber,
               'firebase_uid' => $faker->swiftBicNumber,
               'customer_id' => $faker->numberBetween($min = 1, $max = 100),
               'created_at' =>$faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null) ,
           ]);
        }
    }
}
