<?php

namespace Database\Seeders;

use App\Models\Additional;
use App\Models\Order;
use App\Models\OrderAdditionalPrice;
use App\Models\OrderItem;
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
        $this->orders();
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

    public function orders()
    {
        for ($i = 1; $i < 21; $i++) {
            Order::create([
                'package_name' => 'Demo Package ' . $i,
                'package_details' => 'Demo Package Details ' . $i,
                'package_price' => rand(40, 400),
                'tips' => rand(20, 60),
                'customer_name' => fake()->name(),
                'customer_phone' => fake()->phoneNumber(),
                'customer_address' => fake()->address(),
            ]);
        }

        for ($i = 0; $i < 201; $i++) {
            OrderItem::create([
                'order_id' => rand(1, 20),
                'vehicle_name' => 'Demo Car name ' . $i,
                'vehicle_model' => 'Demo Car model ' . $i,
                'image' => fake()->imageUrl(),
                'type' => fake()->randomElement(['classic', 'modern']),
                'total_additional_price' => rand(300, 1200)
            ]);
        }

        for ($i = 0; $i < 300; $i++) {
            OrderAdditionalPrice::create([
                'order_item_id' => rand(1, 200),
                'title' => 'Demo additional item ' . $i,
                'details' => 'Demo additional item Details' . $i,
                'price' => rand(20, 200),
            ]);
        }
    }
}
