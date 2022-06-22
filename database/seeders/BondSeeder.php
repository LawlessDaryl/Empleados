<?php

namespace Database\Seeders;

use App\Models\Bond;
use Illuminate\Database\Seeder;

class BondSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bond ::create([
            'name' => 'Bono antiguedad',
            'minimum' => '2',
            'maximum' => '4',
            'percentage' => '5'
        ]);
        Bond ::create([
            'name' => 'Bono antiguedad',
            'minimum' => '5',
            'maximum' => '7',
            'percentage' => '11'
        ]);
        Bond ::create([
            'name' => 'Bono antiguedad',
            'minimum' => '8',
            'maximum' => '10',
            'percentage' => '18'
        ]);
        Bond ::create([
            'name' => 'Bono antiguedad',
            'minimum' => '11',
            'maximum' => '14',
            'percentage' => '26'
        ]);
        Bond ::create([
            'name' => 'Bono antiguedad',
            'minimum' => '15',
            'maximum' => '19',
            'percentage' => '34'
        ]);
        Bond ::create([
            'name' => 'Bono antiguedad',
            'minimum' => '20',
            'maximum' => '24',
            'percentage' => '42'
        ]);
        Bond ::create([
            'name' => 'Bono antiguedad',
            'minimum' => '25',
            'maximum' => '100',
            'percentage' => '50'
        ]);
    }
}
