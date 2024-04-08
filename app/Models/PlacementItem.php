<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlacementItem extends Model
{
    use HasFactory;
    protected $table = 'trx_placement_item';
    protected $fillable = [
        'item_id', 'item_code', 'item_name',
        'location_id', 'location_name', 
        'qty',
        'user_id', 'user_name'
    ];

    public function item(): BelongsToMany {
        return $this->belongsToMany(Item::class, 'item_id');
    }

    public function location(): BelongsTo {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
