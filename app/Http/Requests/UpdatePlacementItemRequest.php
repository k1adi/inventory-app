<?php

namespace App\Http\Requests;

use App\Models\Item;
use App\Models\PlacementItem;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlacementItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_id' => ['required', 'integer', 'exists:mst_items,id'],
            'location_id' => ['required', 'integer', 'exists:mst_locations,id'],
            'qty' => [ 'required', 'integer', function ($attr, $value, $fail) {
                    $item = Item::findOrFail($this->item_id);
                    
                    // Hitung total qty pada placement_item berdasarkan item_id dari request
                    $totalQty = PlacementItem::where('item_id', $this->item_id)
                        ->where('id', '!=', $this->route('placement_item')->id) // Pengecualian untuk baris data yang sedang diedit
                        ->sum('qty');
                    
                    // Kurangi qty pada tabel item dengan total qty pada placement_item
                    $availableQty = $item->qty - $totalQty;
                    
                    if ($value > $availableQty) {
                        $fail('Jumlah qty yang di-input melebihi qty yang tersedia. Qty tersisa: ' . $availableQty);
                    }
                },
            ],
        ];
    }
}
