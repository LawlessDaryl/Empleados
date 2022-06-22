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
            'minimum' => '2',
            'maximum' => '4',
            'percentage' => '5',
            'description' => 'Bono antiguedad D.S. 861'
        ]);
        Bond ::create([
            'minimum' => '5',
            'maximum' => '7',
            'percentage' => '11',
            'description' => 'Bono antiguedad D.S. 861'
        ]);
        Bond ::create([
            'minimum' => '8',
            'maximum' => '10',
            'percentage' => '18',
            'description' => 'Bono antiguedad D.S. 861'
        ]);
        Bond ::create([
            'minimum' => '11',
            'maximum' => '14',
            'percentage' => '26',
            'description' => 'Bono antiguedad D.S. 861'
        ]);
        Bond ::create([
            'minimum' => '15',
            'maximum' => '19',
            'percentage' => '34',
            'description' => 'Bono antiguedad D.S. 861'
        ]);
        Bond ::create([
            'minimum' => '20',
            'maximum' => '24',
            'percentage' => '42',
            'description' => 'Bono antiguedad D.S. 861'
        ]);
        Bond ::create([
            'minimum' => '25',
            'maximum' => '100',
            'percentage' => '50',
            'description' => 'Bono antiguedad D.S. 861'
        ]);
    }
}
