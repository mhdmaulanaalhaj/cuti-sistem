<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcurementRequestRequest extends FormRequest
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
    public function rules()
{
    return [
        'type_request' => 'required|in:new_request,restock',
        'material_id'  => 'required_if:type_request,restock|nullable|exists:inventories,id',
        'item_name'    => 'required_if:type_request,new_request|nullable|string|max:255',
        'quantity'     => 'required|integer|min:1',
        'reason'       => 'nullable|string',
        'photo'        => 'required_if:type_request,new_request|image|mimes:jpg,jpeg,png|max:2048',
    ];
}

}
