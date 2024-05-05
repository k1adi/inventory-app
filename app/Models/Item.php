<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Item extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'mst_items';
    protected $fillable = ['code', 'name', 'qty', 'category_id'];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function inventories(): HasMany {
        return $this->hasMany(Inventory::class, 'item_id');
    }
}
