<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

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
            'auto_name' => 'required',
            'country_list' => 'required',
            'category_list' => 'required',
            'auto_id' => 'required',
            'auto_city' => 'required',
            'auto_comment' => 'required|min:20|max:500',
		];
	}

    public function messages()
    {
        return[
            'auto_name.required' => 'Prašome įvesti automobilio pavadinimą',
            'country_list.required' => 'Pasirinkite bent vieną šalį!',
            'category_list.required' => 'Pasirinkite bent vieną kategoriją',
            'auto_id.required' => 'Pasirinkite automobilio tipą',
            'auto_city.required' => 'Įveskite automobilio adresą arba miestą',
            'auto_comment.required' => 'Prašome aprašyti savo automobilį',
            'auto_comment.min' => 'Automobilio aprašymas turėtų būti bent iš 20 simbolių',
            'auto_comment.max' => 'Automobilio aprašymas neturėtų viršyti 500 simbolių',

        ];
    }

}
