<?php

namespace App\Http\Resources;

use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => MyHelper::encrypt_id($this->id),
            'name' => $this->name,
            'inventory' => $this->inventories->map(function ($inventory) {
                return [
                    'id' => MyHelper::encrypt_id($inventory->id),
                    'item_code' => $inventory->item->code,
                    'item_name' => $inventory->item->name,
                    'item_qty' => $inventory->qty,
                    'managed_by' => $inventory->user->name,
                    'created_at' => MyHelper::formatDate($inventory->created_at),
                    'updated_at' => MyHelper::formatDate($inventory->updated_at),
                ];
            }),
        ];
    }
}
