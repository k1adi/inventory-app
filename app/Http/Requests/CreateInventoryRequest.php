<?php

namespace App\Http\Requests;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class CreateInventoryRequest extends FormRequest
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
            'qty' => ['required', 'integer', function($attr, $value, $fail) {
                $item = Item::find($this->item_id);
                if(!$item){
                    $fail('Gagal mendapatkan qty dengan ID item tersebut!');
                } else {
                    $placementQty = Inventory::where('item_id', $this->item_id)->sum('qty');
                    $remainingQty = $item->qty - $placementQty;
                    
                    if ($value > $remainingQty) {
                        $fail('Jumlah qty yang di-input melebihi qty yang tersedia. Qty tersisa: '.$remainingQty);
                    }
                }
            }],
        ];
    }
}
