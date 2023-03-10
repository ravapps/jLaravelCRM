<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LeadImportRequest extends Request
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
            'email' => 'required|email',
            'function' => 'required',
            'phone' => 'regex:/^\d{5,15}?$/',
            'mobile' => 'regex:/^\d{5,15}?$/',
            'fax' => 'regex:/^\d{5,15}?$/'
        ];
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
       // $this->merge(['ip_address' => $this->ip()]);
        $this->merge(['tags' => implode(',', $this->get('tags', []))]);
        return parent::getValidatorInstance();
    }

	public function messages()
	{
		return [
			'phone.regex' => 'Phone number can be only numbers',
			'mobile.regex' => 'Mobile number can be only numbers',
			'fax.regex' => 'Fax number can be only numbers',
		];
	}
}
