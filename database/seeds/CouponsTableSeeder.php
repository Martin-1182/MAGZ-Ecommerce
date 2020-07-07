<?php

use App\Coupon;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code' => 'XY17X',
            'type' => 'fixed',
            'value' => 3000,
        ]);
        Coupon::create([
            'code' => 'ZUZKA1988',
            'type' => 'percent',
            'percent_off' => 50,
        ]);
    }
}