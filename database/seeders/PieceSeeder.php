<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PieceSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //Pieza 1
        DB::table('pieces')->insert(['name'=>'Psique',
        'user_id'=>'1',
        'description'=>'Persona y sombra',
        'sold'=>false,
        'total_materials'=>3]);

        //Pieza 2
        DB::table('pieces')->insert(['name'=>'Colador',
        'user_id'=>'2',
        'description'=>'Es un colador',
        'sold'=>true,
        'total_materials'=>2]);

        //Pieza 3
        DB::table('pieces')->insert(['name'=>'Mariposa',
        'user_id'=>'2',
        'description'=>'Figura mariposa',
        'sold'=>false,
        'total_materials'=>3]);

        for($i=6;$i<=10;$i++){
            DB::table('pieces')->insert(['name'=>'name'.$i,
            'user_id'=>$i,
            'description'=>'description'.$i,
            'sold'=>false,
            'total_materials'=>1]);
        }
    }
}
