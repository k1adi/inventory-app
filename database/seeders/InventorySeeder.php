<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventory::create([
            'item_id' => 1,
            'item_code' => 'kode001',
            'item_name' => 'Pulpen',
            'location_id' => 5,
            'location_name' => 'Ruang Manajer',
            'qty' => 5,
            'user_id' => 11,
            'user_name' => 'admin',
        ]);
        Inventory::create([
            'item_id' => 1,
            'item_code' => 'kode001',
            'item_name' => 'Pulpen',
            'location_id' => 6,
            'location_name' => 'Ruang Meeting',
            'qty' => 10,
            'user_id' => 11,
            'user_name' => 'admin',
        ]);
        Inventory::create([
            'item_id' => 3,
            'item_code' => 'kode003',
            'item_name' => 'Monitor',
            'location_id' => 2,
            'location_name' => 'Lantai 1',
            'qty' => 3,
            'user_id' => 11,
            'user_name' => 'admin',
        ]);
        Inventory::create([
            'item_id' => 3,
            'item_code' => 'kode003',
            'item_name' => 'Monitor',
            'location_id' => 3,
            'location_name' => 'Lantai 2',
            'qty' => 5,
            'user_id' => 11,
            'user_name' => 'admin',
        ]);
        Inventory::create([
            'item_id' => 4,
            'item_code' => 'kode004',
            'item_name' => 'Keyboard',
            'location_id' => 2,
            'location_name' => 'Lantai 1',
            'qty' => 3,
            'user_id' => 11,
            'user_name' => 'admin',
        ]);
        Inventory::create([
            'item_id' => 4,
            'item_code' => 'kode004',
            'item_name' => 'Keyboard',
            'location_id' => 3,
            'location_name' => 'Lantai 2',
            'qty' => 5,
            'user_id' => 11,
            'user_name' => 'admin',
        ]);
    }
}
