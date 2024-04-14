<?php

namespace App\Http\Requests\Api;

use App\Helpers\MyHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
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
        $encryptId = $this->route('location');
        $id = MyHelper::decrypt_id($encryptId);

        return [
            'name' => ['required', 'string', Rule::unique('mst_locations')->ignore($id)],
        ];
    }
}
