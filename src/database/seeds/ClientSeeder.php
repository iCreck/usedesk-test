<?php

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Phone;
use App\Models\Email;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::truncate();
        Phone::truncate();
        Email::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $client = Client::create([
                'name' => $faker->name,
                'lastname' => $faker->lastName,
            ]);
            for ($j = 0; $j < rand(1, 2); $j++) {
                $client->phones()->create(['phone' => $faker->e164PhoneNumber]);
            }
            for ($k = 0; $k < rand(1, 2); $k++) {
                $client->emails()->create(['email' => $faker->email]);
            }
        }
    }
}
