<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'trx_inventory';
    protected $fillable = [
        'item_id', 'item_code', 'item_name',
        'location_id', 'location_name', 
        'qty',
        'user_id', 'user_name'
    ];

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function location(): BelongsTo {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
