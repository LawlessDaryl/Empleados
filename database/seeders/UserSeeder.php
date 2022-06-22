<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Esteban',
            'lastname' => 'Dido',
            'phone' => '72854669',
            'email' => 'empleado@gmail.com',
            'password' => bcrypt('123'),
            'condition' => 'active',  
            'role' => 'employee',     
            'position_id' => '1'     
        ]);
    }
}