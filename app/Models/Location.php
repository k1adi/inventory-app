<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;
    protected $table = 'mst_locations';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function inventories(): HasMany {
        return $this->hasMany(Inventory::class, 'location_id');
    }
}
