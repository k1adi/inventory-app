<?php

namespace App\Http\Resources;

use App\Helpers\MyHelper;
use Doctrine\Inflector\Rules\Pattern;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalPlacement = $this->placement_item->sum('qty');
        $availableQty = $this->qty - $totalPlacement;

        return [
            'id' => MyHelper::encrypt_id($this->id),
            'code' => $this->code,
            'name' => $this->name,
            'qty' => $this->qty,
            'placement_qty' => $totalPlacement,
            'available_qty' => $availableQty,
            'category' => $this->category->name,
            'created_at' => MyHelper::formatDate($this->created_at),
            'updated_at' => MyHelper::formatDate($this->updated_at),
            'placement_item' => $this->placement_item->map(function ($inventory) {
                return [
                    'location' => $inventory->location->name,
                    'qty' => $inventory->qty,
                    'managed_by' => $inventory->user_name,
                    'created_at' => MyHelper::formatDate($inventory->created_at),
                    'updated_at' => MyHelper::formatDate($inventory->updated_at),
                ];
            }),
        ];
    }
}
