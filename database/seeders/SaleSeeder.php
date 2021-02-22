<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Venta 1
        DB::table('sales')->insert(['name'=>'Barata',
        'user_id'=>'2',
        'piece_id'=>'2',
        'price'=>200]);
    }
}