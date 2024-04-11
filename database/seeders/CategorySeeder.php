<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'ATK', // 1
        ]);
        Category::create([
            'name' => 'Elektronik', // 2
        ]);
        Category::create([
            'name' => 'Komputer', // 3
        ]);
        Category::create([
            'name' => 'Kendaraan', // 4
        ]);
        Category::create([
            'name' => 'Alat Keamanan', // 5
        ]);
        Category::create([
            'name' => 'Alat Makan', // 6
        ]);
        Category::create([
            'name' => 'Alat Kebersihan', // 7
        ]);
        Category::create([
            'name' => 'Kelistrikan', // 8
        ]);
    }
}
