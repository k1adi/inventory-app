<?php

namespace App\Http\Resources;

use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailResource extends JsonResource
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
            'name' => $this->name,
            'items' => $this->items->map(function ($item) {
                return [
                    'id' => MyHelper::encrypt_id($item->id),
                    'code' => $item->code,
                    'name' => $item->name,
                    'qty' => $item->qty
                ];
            }),
        ];
    }
}
