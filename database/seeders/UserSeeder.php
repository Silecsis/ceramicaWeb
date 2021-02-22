<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User 1
        DB::table('users')->insert(['name'=>'MJ',
        'email'=>'mj@gmail.com',
        'email_verified_at'=>'1991/02/02',
        'password'=>Hash::make("MJ"),
        'type'=>'user',
        'nick'=>'mjnick',
        'img'=>'dada',
        'remember_token'=>'rememberMJ']);

        //User 2
        DB::table('users')->insert(['name'=>'Campon',
        'email'=>'campon@gmail.com',
        'email_verified_at'=>'1991/02/02',
        'password'=>Hash::make("MJ"),
        'type'=>'admin',
        'nick'=>'camponnick',
        'img'=>'papa',
        'remember_token'=>'rememberCampon']);

        //User 3
        DB::table('users')->insert(['name'=>'garcia',
        'email'=>'garcia@gmail.com',
        'email_verified_at'=>'1991/02/02',
        'password'=>Hash::make("MJ"),
        'type'=>'user',
        'nick'=>'garcianick',
        'remember_token'=>'rememberGarcia']);
        
    }
}
