<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('users', 'UsersController@index'); // vartotojų peržiūrai
Route::delete('users/{user_id}', 'UsersController@destroy'); // testuojant, vartotojų pašalinimui
Route::get('users/activate/{key}', 'UsersController@update');// aktyvavimas
Route::patch('users/newkey/{user_id}', 'UsersController@updatekey');
/**************Routes duomenų bazės užpildymui******************/
Route::get('categories/create', 'CategoryController@create');
Route::post('categories', 'CategoryController@store');

Route::get('categories/createauto', 'AutotypesController@create');
Route::post('categories/createauto', 'AutotypesController@store');
/************************************************************/

Route::get('/', 'HomeController@index');

/********************Orders routes*****************************/
Route::get('orders/create', 'OrdersController@create');
Route::post('orders', 'OrdersController@store');
Route::post('orders/search','OrdersController@postsearch');
Route::get('orders/search','OrdersController@getsearch');
Route::get('orders', 'OrdersController@index');
Route::get('orders/client', 'OrdersController@clientindex');
Route::get('orders/provider', 'OrdersController@providerindex');
Route::get('orders/client/{order_key}','OrdersController@showclient');
Route::get('orders/provider/{order_key}/{order_id}', 'OrdersController@showprovider');
Route::patch('orders/provider/{order_key}/{order_id}', 'OrdersController@update');
Route::delete('orders/provider/{order_key}/{order_id}', 'OrdersController@destroy_provider');
Route::delete('orders/client/{order_key}/{order_id}', 'OrdersController@destroy_client');
/**************************************************************/
/********************Evaluation routes*************************/
Route::get('evaluate/{provider_id}', 'EvaluationsController@show');
Route::post('evaluate', 'EvaluationsController@store');
Route::delete('evaluate/{provider_id}/{client_id}', 'EvaluationsController@destroy');


Route::resource('auto_registrations', 'Auto_registrationsController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);