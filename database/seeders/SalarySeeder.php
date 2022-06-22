<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salary;

class SalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Salary ::create([
            'name' => 'Ventas',
            'amount' => '2250',
            'description' => 'salario basico'
        ]);
    }
}
