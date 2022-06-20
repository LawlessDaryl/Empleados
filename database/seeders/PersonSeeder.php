<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Person::create([
            'name' => 'Vicente',
            'lastname' => 'Flores',
            'phone' => '12345678',
            'address' => 'Av.Ayacucho'
        ]);
    }
}
