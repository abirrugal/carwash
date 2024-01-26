<?php

namespace Database\Seeders;

use App\Models\Additional;
use App\Models\Package;
use App\Models\User;
use App\Models\UserVehicle;
use App\Models\VehicleModel;
use App\Models\VehicleName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarwashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->users();
        $this->vehicles();
        $this->userVehicles();
    }

    public function users()
    {
        for ($i = 0; $i < 6; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'phone_code' => rand(11, 99),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address()
            ]);
        }
    }

    public function vehicles()
    {
        for ($i = 1; $i < 100; $i++) {
            VehicleName::create([
                'name' => 'Demo Car ' . $i,
                'type' => fake()->randomElement(['classic', 'modern']),
                'created_by' => rand(1, 5)
            ]);

            VehicleModel::create([
                'model' => 'Demo Car model ' . $i,
                'type' => fake()->randomElement(['classic', 'modern']),
                'created_by' => rand(1, 5)
            ]);
            Package::create([
                'title' => 'Demo Package ' . $i,
                'details' => 'Demo Package Details ' . $i,
                'image' => fake()->imageUrl(),
                'price' => rand(100, 5000),
                'time_limit' => rand(20, 90) . 'minute'
            ]);
            Additional::create([
                'title' => 'Demo additional item ' . $i,
                'mini_title' => 'Demo extra title' . $i,
                'details' => 'Demo additional item Details ' . $i,
                'price' => rand(50, 700),
            ]);
        }
    }

    public function userVehicles()
    {
        for ($i = 1; $i < 6; $i++) {
            UserVehicle::create([
                'user_id' => rand(1, 5),
                'type' => fake()->randomElement(['classic', 'modern']),
                'name' => 'Demo Car ' . $i,
                'model' => 'Demo Car model ' . $i,
                'image' => fake()->imageUrl()
            ]);
        }
    }
}
