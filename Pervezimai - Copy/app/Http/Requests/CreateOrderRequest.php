<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateOrderRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;    //pakeist i false po logino sukurimo
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'category_id' => 'required',
            'pickup_address' => 'required',
            'deliver_address' => 'required',
            'order_date' => 'required',
            'order_comment' => 'required'
		];
	}

}
