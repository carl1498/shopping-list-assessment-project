<?php

namespace App\Http\Requests\LineItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreLineItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => ['required', 'min:1'],
            'item_id' => ['required', 'exists:items,item_id'],
        ];
    }
}
