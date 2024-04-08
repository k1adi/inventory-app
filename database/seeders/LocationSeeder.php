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
            'name' => 'Gudang', // 1
        ]);
        Location::create([
            'name' => 'Lantai 1',  // 2
        ]);
        Location::create([
            'name' => 'Lantai 2',  // 3
        ]);
        Location::create([
            'name' => 'Lantai 3',  // 4
        ]);
        Location::create([
            'name' => 'Ruang Manajer',  // 5
        ]);
        Location::create([
            'name' => 'Ruang Meeting',  // 6
        ]);
        Location::create([
            'name' => 'Ruang Operasional',  // 7
        ]);
        Location::create([
            'name' => 'Ruang Marketing',  // 8
        ]);
        Location::create([
            'name' => 'Ruang Akunting',  // 9
        ]);
    }
}
