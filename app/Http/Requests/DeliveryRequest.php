<?php

namespace App\Http\Requests;


class DeliveryRequest extends Request
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
            'salejob_id' => 'required',
            'delivery_date' => 'required|date_format:"'.config('settings.date_format').'"',

        ];
    }
    public function messages()
    {
        return [
            'product_id.required' => 'A product is required',
            'product_id*.required' => 'A product is required',
        ];
    }
}
