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
            'user_name' => 'empleado',
            'email' => 'empleado@gmail.com',
            'password' => bcrypt('123'),
            'condition' => 'active',
            'person_id' => '1'
        ]);
    }
}
