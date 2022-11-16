<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::create([
            'name'=>'Basma Farouk',
            'email'=>'basma@basma.com',
            'password'=>Hash::make('passowrd'),
            'super_admin'=>1,
            'status'=>'active',
        ]);
    }
}
