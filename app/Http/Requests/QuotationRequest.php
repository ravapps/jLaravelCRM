<?php

namespace App\Http\Requests;

class QuotationRequest extends Request
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
      if($this->method() == 'POST' || $this->method() == 'PUT' ) {
        return [
            'customer_id' => 'required',
            'date' => 'required|date_format:"'.config('settings.date_format').'"',
            'payment_term' => 'required',
            //'product_id.*' => 'required',
            //'product_id' => 'required',
            'status' => 'required'
        ];
      } else {
        return [];
      }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_id.required' => 'A product is required',
            'product_id*.required' => 'A product is required',
            'customer_id.required' => 'The client field is required',
            'sales_person_id.required' => 'The team leader field is required',
            'sales_team_id.required' => 'The sales team field is required',
            'date.required' => 'The starts date field is required'
        ];
    }
}
