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

	// Route::get('/', function () {
	//     return view('welcome');
	// });

//Route::get('login','Registration@index');


//Route::get('/',['middleware' => 'auth', 'uses' =>'Registration@index']);


	
	Route::get('/','Registration@index');

	Route::get('/login',[

			'as' => 'login',

			'uses' => 'Registration@index'

	]);

	Route::post('home',[

			'uses' => 'Registration@customerDetails'

	]);

	Route::get('/logout',[

			'uses' => 'Registration@do_logout'

	]);


	Route::get('/home',[

			'uses' => 'Registration@index',
			'auth'  => 'middleware'

	]);

 Route::get('register','Registration@register_form');



//process the registration form data

//GET Request

Route::get('getRequest',function(){
	if (Request::ajax()) {
		return 'getRequest has loaded completely';
	}
});

// Route::post('postRequest',function(){

// 	if (Request::ajax()) {
			
// 			return Response::json(Request::all());	
// 	}

// });

Route::post('postRequest',[

	'uses' => 'Registration@process_registration',

]);



Route::post('updateUserImage',[

	'uses' => 'Registration@update_user_image',

]);


Route::post('updateUserDetails',[

	'uses' => 'Registration@update_user_details',

]);