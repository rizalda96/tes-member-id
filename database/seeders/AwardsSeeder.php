<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;

class AwardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $awards = [
            ['name' => 'Gift Card IDR 1.000.000', 'type' =>'voucher', 'poin' => '1000000'],
            ['name' => 'Gift Card IDR 2.000.000', 'type' =>'voucher', 'poin' => '2000000'],
            ['name' => 'Gift Card IDR 500.000', 'type' =>'voucher', 'poin' => '500000'],
            ['name' => 'Old Fashion cake', 'type' =>'products', 'poin' => '500000'],
        ];

        foreach ($awards as $item) {
            Award::create($item);
        }
    }
}
