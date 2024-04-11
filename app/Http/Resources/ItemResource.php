<?php

namespace App\Http\Resources;

use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'category' => $this->category->name,
            'qty' => $this->qty,
            'created_at' => MyHelper::formatDate($this->created_at),
            'updated_at' => MyHelper::formatDate($this->updated_at),
        ];
    }
}
