<?php

namespace Database\Seeders;

use App\Enums\GenderEnum;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = GenderEnum::values();
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'];
        $address = ['Jalan Kembangan', 'Jalan Krendang', 'Jalan Siliwangi'];

        for ($i = 1; $i <= 50; $i++) {
            Customer::create([
                'name' => 'Customer ' . $i,
                'city' => $cities[array_rand($cities)],
                'gender' => $genders[array_rand($genders)],
                'address' => $address[array_rand($address)],
            ]);
        }
    }
}
