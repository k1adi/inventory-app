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
        // return parent::toArray($request);
        // return [
        //     'id' => MyHelper::encrypt_id($this->id),
        //     'item_code' => $this->item->code,
        //     'item_name' => $this->item->name,
        //     'location_name' => $this->location->name,
        //     'qty' => $this->qty,
        //     'user_name' => $this->user->name,
        //     'created_at' => MyHelper::formatDate($this->created_at),
        //     'updated_at' => MyHelper::formatDate($this->updated_at),
        // ];
        return [
            'id' => MyHelper::encrypt_id($this->id),
            'item_id' => MyHelper::encrypt_id($this->item_id),
            'qty' => $this->qty,
            'location_id' => MyHelper::encrypt_id($this->location_id),
            'user_id' => MyHelper::encrypt_id($this->user_id),
            'created_at' => MyHelper::formatDate($this->created_at),
            'updated_at' => MyHelper::formatDate($this->updated_at),
        ];
    }
}
