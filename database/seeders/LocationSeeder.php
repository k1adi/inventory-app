<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'name' => 'Gudang',
        ]);
        Location::create([
            'name' => 'Lantai 1',
        ]);
        Location::create([
            'name' => 'Lantai 2',
        ]);
        Location::create([
            'name' => 'Lantai 3',
        ]);
        Location::create([
            'name' => 'Ruang Manajer',
        ]);
        Location::create([
            'name' => 'Ruang Meeting',
        ]);
        Location::create([
            'name' => 'Ruang Operasional',
        ]);
        Location::create([
            'name' => 'Ruang Marketing',
        ]);
        Location::create([
            'name' => 'Ruang Akunting',
        ]);
    }
}
