<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('address')->name('api.')->group(function() {
	Route::get('/', 'Api\AddressController@index')->name('address');
	Route::get('provinces/{province}', 'Api\AddressController@provices')->name('province');
	Route::get('districts/{district}', 'Api\AddressController@districts')->name('district');
	Route::get('sub_districts/{sub_district}', 'Api\AddressController@sub_districts')->name('sub_districts');

	Route::get('provinces/{province}', 'Api\AddressController@getProvices')->name('get.province');
	Route::get('districts/{district}', 'Api\AddressController@getDistricts')->name('get.district');
	Route::get('postal/{subdistrict}', 'Api\AddressController@getPostalCode')->name('get.postalcode');
	Route::get('searchPostal/{postalcode}', 'Api\AddressController@searchPostalCode')->name('search.postalcode');
});
