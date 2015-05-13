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
Route::get('users', 'UsersController@index'); // kurtas mokymuisi
/***********Routes duomenų bazės užpildymui******************/
Route::get('categories/create', 'CategoryController@create');
Route::post('categories', 'CategoryController@store');

Route::get('categories/createauto', 'AutotypesController@create');
Route::post('categories/createauto', 'AutotypesController@store');
/************************************************************/

Route::get('/', 'HomeController@index');

Route::get('orders/create', 'OrdersController@create');
Route::post('orders', 'OrdersController@store');
Route::post('orders/search','OrdersController@postsearch');
Route::get('orders/search','OrdersController@getsearch');

Route::resource('auto_registrations', 'Auto_registrationsController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);