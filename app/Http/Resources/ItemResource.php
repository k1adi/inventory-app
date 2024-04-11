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
        // return parent::toArray($request);

        // return [
        //     'id' => MyHelper::encrypt_id($this->id),
        //     'code' => $this->code,
        //     'name' => $this->name,
        //     'qty' => $this->qty,
        //     'category' => $this->category->name,
        //     'created_at' => MyHelper::formatDate($this->created_at),
        //     'updated_at' => MyHelper::formatDate($this->updated_at),
        // ];
        
        return [
            'id' => MyHelper::encrypt_id($this->id),
            'code' => $this->code,
            'name' => $this->name,
            'qty' => $this->qty,
            'category_id' => MyHelper::encrypt_id($this->category_id),
            'created_at' => MyHelper::formatDate($this->created_at),
            'updated_at' => MyHelper::formatDate($this->updated_at),
        ];
    }
}
