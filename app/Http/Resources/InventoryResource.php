<?php

namespace App\Http\Resources;

use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => MyHelper::encrypt_id($this->id),
            'item_code' => $this->item_code,
            'item_name' => $this->item_name,
            'location_name' => $this->location_name,
            'qty' => $this->qty,
            'user_name' => $this->user_name,
            'created_at' => MyHelper::formatDate($this->created_at),
            'updated_at' => MyHelper::formatDate($this->updated_at),
        ];
    }
}
