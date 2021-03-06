<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class iis_concertTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $faker = Faker::create();

//      foreach(range(1,10) as $index){
//        DB::table('iis_concert')->insert([
//          'iis_eventid' => $index,
//          'capacity' => $faker->numberBetween(10000, 50000),
//          'date' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
//          'created_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
//          'updated_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now')
//        ]);
//      }

        foreach(range(1,3) as $index){
            DB::table('iis_concert')->insert([
                'iis_eventid' => $index,
                'capacity' => $faker->numberBetween(10000, 50000),
                'date' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
                'created_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
                'updated_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now')
            ]);
        }

    }
}
