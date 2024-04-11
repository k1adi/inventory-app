<?php

namespace App\Http\Resources;

use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryDetailResource extends JsonResource
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
            'item_code' => $this->item->code,
            'item_name' => $this->item->name,
            'category' => $this->item->category->name,
            'qty' => $this->qty,
            'location' => $this->location->name,
            'managed_by' => $this->user->name,
            'created_at' => MyHelper::formatDate($this->created_at),
            'updated_at' => MyHelper::formatDate($this->updated_at),
        ];
    }
}
