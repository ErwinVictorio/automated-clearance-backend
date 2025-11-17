<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $total = 2000;
  

        for ($i = 0; $i < $total; $i++) {
            DB::table('clients')->insert([
                'company_name'         => $faker->company(), // mas bagay kaysa name()
                'contact_number'       => $faker->phoneNumber(),
                'address'              => $faker->address(),
                'salesList_no'         => $faker->randomNumber(5, true), // pwede din $faker->unique()->randomDigit()
                'contact_person'       => $faker->name(),
                'contact_number_person' => $faker->phoneNumber(),
                'bank_account_number'  => $faker->bankAccountNumber(),
                'item_name'            => $faker->word(),
                'model_number'         => $faker->bothify('??###'), // sample pattern
                'specification'        => $faker->sentence(),
                'quantity'             => $faker->numberBetween(1, 100),
                'salesman_id'          => $faker->randomNumber(),
                'status'               => $faker->randomElement(['active', 'inactive']),
                'email'                => $faker->email(),
            ]);
        }



        //
    }
}
