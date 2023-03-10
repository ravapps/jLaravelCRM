<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest {

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
            'assigned_to' => 'required',
			'subject' => 'required',
			'description' => 'required',
            'start_date' => 'required',
            'due_date' => 'required',
            'status' => 'required',
            'priority' => 'required'
		];
	}

}
