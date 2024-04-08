<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;
    protected $table = 'mst_locations';

    public function placement_item(): HasMany {
        return $this->hasMany(PlacementItem::class, 'location_id');
    }
}
