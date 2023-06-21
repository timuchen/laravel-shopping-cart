<?php

namespace Timuchen\ShoppingCart\Http\Requests;

use Timuchen\ShoppingCart\Http\Requests\APIRequest;

class CheckoutItemUpdateRequest extends APIRequest
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
            'qty' => 'required|integer',
            'options' => 'sometimes|nullable|array',
        ];
    }
}
