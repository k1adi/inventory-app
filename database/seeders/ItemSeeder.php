<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'code' => 'kode001',
            'name' => 'Pulpen',
            'qty' => 100,
            'category_id' => '1',
        ]);
        Item::create([
            'code' => 'kode002',
            'name' => 'Penggaris',
            'qty' => 20,
            'category_id' => '1',
        ]);
        Item::create([
            'code' => 'kode003',
            'name' => 'Monitor',
            'qty' => 30,
            'category_id' => '3',
        ]);
        Item::create([
            'code' => 'kode004',
            'name' => 'Keyboard',
            'qty' => 30,
            'category_id' => '3',
        ]);
        Item::create([
            'code' => 'kode005',
            'name' => 'Mouse Logitech',
            'qty' => 30,
            'category_id' => '3',
        ]);
        Item::create([
            'code' => 'kode006',
            'name' => 'Printer',
            'qty' => 10,
            'category_id' => '2',
        ]);
        Item::create([
            'code' => 'kode007',
            'name' => 'Scanner',
            'qty' => 10,
            'category_id' => '2',
        ]);
        Item::create([
            'code' => 'kode008',
            'name' => 'Fax',
            'qty' => 5,
            'category_id' => '2',
        ]);
        Item::create([
            'code' => 'kode009',
            'name' => 'Stop Kontak',
            'qty' => 20,
            'category_id' => '8',
        ]);
        Item::create([
            'code' => 'kode010',
            'name' => 'Lampu Ruangan',
            'qty' => 50,
            'category_id' => '8',
        ]);
        Item::create([
            'code' => 'kode011',
            'name' => 'Piring',
            'qty' => 20,
            'category_id' => '6',
        ]);
        Item::create([
            'code' => 'kode012',
            'name' => 'Gelas',
            'qty' => 30,
            'category_id' => '6',
        ]);
        Item::create([
            'code' => 'kode013',
            'name' => 'Sapu',
            'qty' => 10,
            'category_id' => '7',
        ]);
        Item::create([
            'code' => 'kode014',
            'name' => 'Pel',
            'qty' => 10,
            'category_id' => '7',
        ]);
    }
}
