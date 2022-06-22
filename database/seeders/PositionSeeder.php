<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position ::create([
            'name' => 'Ventas',            
            'description' => 'salario basico',
            'department_id' => '1',
            'salary_id' => '1'
        ]);
    }
}
