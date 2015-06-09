<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
            'surname' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
            'city' => 'required|max:255',
            'address' => 'required|max:255',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
            'surname' => $data['surname'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
            'company' => $data['company'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'address' => $data['address'],
            'comment' => $data['comment'],
            'key' =>$data['key']
		]);
	}

}
