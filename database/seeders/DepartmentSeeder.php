<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department ::create([
            'name' => 'Ventas',
            'description' => 'Departamento encargado de las ventas de la empresa'
        ]);
    }
}
