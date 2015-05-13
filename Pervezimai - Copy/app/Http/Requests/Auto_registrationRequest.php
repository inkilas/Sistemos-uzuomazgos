<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class Auto_registrationRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
     *
     * laikinai true, po to pakeist i false, kai padarysiu logina
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
            'auto_name' => 'required',
            'country_list' => 'required',
            'category_list' => 'required',
            'auto_id' => 'required',
            'auto_city' => 'required',
            'auto_comment' => 'required',
		];
	}

}
