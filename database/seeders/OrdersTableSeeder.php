<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Create sample orders
        foreach (range(1, 20) as $index) {
            Order::create([
                'name' => $faker->name,
                'order_id' => $faker->unique()->uuid,
                'tracking_id' => $faker->unique()->uuid,
                'dispatch' => 0,
                'origin_address' => '123 Street, City',
                'pincode' => $faker->unique()->randomNumber(6),
                'delivery_address' => '456 Avenue, Town',
                'delivery_pincode' => $faker->unique()->randomNumber(6),
                'delivered_at' => now()->addDays(2),
            ]);
        }
    }
}
?>