<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CreateOrderRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        if (! Auth::check()){
            return false;
        }

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
            'category_id' => 'required',
            'pickup_address' => 'required',
            'deliver_address' => 'required',
            'order_date' => 'required',
            'order_comment' => 'required|min:20|max:500'
		];
	}

    public function messages()
    {
        return[
            'category_id.required' => 'Prašome pasirinkti kategoriją',
            'pickup_address.required' => 'Prašome įvesti paėmimo adresą!',
            'deliver_address.required' => 'Prašome įvesti pristatymo adresą',
            'order_date.required' => 'Įveskite datą',
            'order_comment.required' => 'Aprašykite savo užsakymą',
            'order_comment.min' => 'Užsakymo aprašymas turėtų būti bent iš 20 simbolių',
            'order_comment.max' => 'Užsakymo aprašymas neturėtų viršyti 500 simbolių',

        ];
    }

}
