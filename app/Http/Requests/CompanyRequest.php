<?php

namespace App\Http\Requests;

use Efriandika\LaravelSettings\Facades\Settings;

class CompanyRequest extends Request
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
        $minimum_characters = Settings::get('minimum_characters');
        $max_upload_file_size = Settings::get('max_upload_file_size');
        $allowed_extensions = Settings::get('allowed_extensions');

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'name' => 'required|min:'.$minimum_characters.'|max:50',
                    'phone' => 'required|regex:/^\d{5,15}?$/',
                    'website' => 'required|url',
                    'mpostalcode' => 'required',
                    'mstreet' => 'required',
                    'mbuilding' => 'required',
                    'munitnofrom'    => 'required',
                    'groupbranch.*.sitelocation' => 'required',
                    'groupbranch.*.postalcode' => 'required',
                    'groupbranch.*.branchcategory' => 'required',
                    'groupbranch.*.contact' => 'required',
                    'company_avatar_file' => 'mimes:'.$allowed_extensions.'|image|max:'.$max_upload_file_size,
                ];
            }
            case 'PUT':
            case 'pluck': {
                return [
                    'name' => 'required|min:'.$minimum_characters.'|max:50',
                    'phone' => 'required|regex:/^\d{5,15}?$/',
                    'website' => 'required|url',
                    'mpostalcode' => 'required',
                    'mstreet' => 'required',
                    'mbuilding' => 'required',
                    'munitnofrom'    => 'required',
                    'groupbranch.*.sitelocation' => 'required',
                    'groupbranch.*.postalcode' => 'required',
                    'groupbranch.*.branchcategory' => 'required',
                    'groupbranch.*.contact' => 'required',
                    'company_avatar_file' => 'mimes:'.$allowed_extensions.'|image|max:'.$max_upload_file_size,
                ];
            }
            default:
                break;
        }

        return [

        ];
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        //$this->merge(['ip_address' => $this->ip()]);
        //$this->merge(['register_time' => strtotime(date('d F Y g:i a'))]);
        return parent::getValidatorInstance();
    }

	public function messages()
	{
		return [
		    'website.required' => 'The company website field is required.',
			'phone.required' => 'The phone number can be only numbers',
			'mobile.regex' => 'Mobile number can be only numbers',
			'fax.regex' => 'Fax number can be only numbers',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
            'city_id.required' => 'The city field is required.',
            'groupbranch.*.sitelocation.required' => 'One of the row have empty site location field which is required on branch data.',
            'groupbranch.*.sitelocation' => 'required',
            'groupbranch.*.postalcode.required' => 'One of the row have empty postalcode field which is required on branch data.',
            'groupbranch.*.branchcategory.required' => 'One of the row have empty branch category field which is required on branch data.',
            'groupbranch.*.contact.required' => 'One of the row have empty contact field which is required on branch data.',
		];
	}
}
