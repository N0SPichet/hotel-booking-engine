<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Create Home Route
Route::get('/', 'PagesController@index');
Route::post('/search', 'PagesController@indexSearch')->name('search');
// Route::get('autocomplete', 'PagesController@index');
// Route::get('searchajax', ['as'=>'searchajax','uses'=>'PagesController@searchResponse']);

//Create PagesController Route
Route::get('/home', 'PagesController@index')->name('home');
Route::get('diaries/mydiaries', 'PagesController@mydiaries')->name('diaries.mydiaries');
Route::get('summary', 'PagesController@summary')->name('summary');
Route::get('about-us', 'PagesController@aboutus')->name('aboutus');


//Create resource route for UserController
Route::resource('users', 'UserController');
Route::prefix('users')->name('users.')->group(function () {
	Route::get('{user}/description', 'UserController@description')->name('description');
	Route::get('{user}/profile', 'UserController@userprofile')->name('profile');
	Route::get('{user}/verify', 'UserController@verify_user')->name('verify-user');
	Route::get('verification/index', 'UserController@verify_index')->name('verify-index');
	Route::get('verification/{user}', 'UserController@verify_show')->name('verify-show');
	Route::post('{user}/block', 'UserController@block')->name('block');
	Route::post('{user}/updateimage', 'UserController@updateimage')->name('updateimage');
	Route::post('verification/send_request', 'UserController@verify_request')->name('verify-request');
	Route::post('verification/{user}/approve', 'UserController@verify_approve')->name('verify-approve');
	Route::post('verification/{id}/reject', 'UserController@verify_reject')->name('verify-reject');
});

//Create resource route for RentalController
Route::resource('rentals', 'RentalController');
Route::post('rentals/agreement', 'RentalController@rentals_agreement')->name('rentals.agreement');
Route::post('rentals/{id}/acceptnew', 'RentalController@acceptnew')->name('rentals.acceptnew');
Route::post('rentals/{id}/rejectnew', 'RentalController@rejectnew')->name('rentals.rejectnew');
Route::get('trip/mytrips', 'RentalController@mytrip')->name('mytrips');
Route::get('trip/mytrips/not_review', 'RentalController@not_reviews')->name('mytrips.reviews');
Route::get('rentals/myroom/rentmyrooms', 'RentalController@rmyrooms')->name('rentals.rmyrooms');
Route::get('rentals/myroom/histories', 'RentalController@rhistories')->name('rentals.rhistories');
Route::post('checkin/code/check', 'RentalController@checkcode')->name('checkin.code');
Route::post('rentals/{id}/approve', 'RentalController@rapproved')->name('rentals.approve');
Route::post('mytrips/{id}/cancel', 'RentalController@rcancel')->name('rental.rentalcancel');
Route::post('rentals/{id}/reject', 'RentalController@rejecttrip')->name('rentals.reject');

//Create resource route for DiaryController
Route::resource('diaries', 'DiaryController');
Route::get('diaries/{id}/single', 'DiaryController@single')->name('diary.single');
Route::post('diaries/{id}/subscribe', 'DiaryController@subscribe')->name('diary.subscribe');
Route::post('diaries/{id}/unsubscribe', 'DiaryController@unsubscribe')->name('diary.unsubscribe');
Route::get('trip/{id}/diary', 'DiaryController@tripdiary')->name('tripdiary');
Route::get('trip/{id}/diary/day/{day}/edit', 'DiaryController@tripdiary_edit')->name('tripdiary_edit');
Route::put('trip/{id}/diary/update', 'DiaryController@tripdiary_update')->name('tripdiary_update');
Route::get('trip/{id}/diary/delete', 'DiaryController@tripdiary_destroy')->name('tripdiary_destroy');
Route::get('trip/{id}/diary/delete/image', 'DiaryController@detroyimage')->name('diaries.detroyimage');

//Create resource route for CategoryController
Route::resource('categories', 'CategoryController', ['except' => ['create']]);

//Create resource route for TagController
Route::resource('tags', 'TagController', ['except' => ['create']]);

//Create resource route for CommentController
Route::resource('comments', 'CommentController');
Route::get('comments/{id}/delete', 'CommentController@delete')->name('comments.delete');

//Create resource route for HouseitemController
Route::resource('houseamenities', 'HouseamenityController', ['except' => ['create']]);

//Create route for hosts
Route::prefix('hosts')->name('hosts.')->group(function() {
	Route::get('introduction-hosting-room', 'PagesController@introroom')->name('introroom');
	Route::get('introduction-hosting-apartment', 'PagesController@introapartment')->name('introapartment');
});

//Create resource route for RoomController
Route::resource('rooms', 'RoomController');
Route::prefix('rooms')->name('rooms.')->group(function() {
	Route::get('my-room/{user}', 'RoomController@index_myroom')->name('index-myroom');
	Route::get('owner/{house}', 'RoomController@owner')->name('owner');
	Route::get('image/{image}/delete', 'RoomController@detroyimage')->name('detroyimage');
});

//Create resource route for ApartmentController
Route::resource('apartments', 'ApartmentController');
Route::prefix('apartments')->name('apartments.')->group(function() {
	Route::get('my-apartment/{user}', 'ApartmentController@index_myapartment')->name('index-myapartment');
	Route::get('owner/{house}', 'ApartmentController@owner')->name('owner');
	Route::get('image/{image}/delete', 'ApartmentController@detroyimage')->name('detroyimage');
});

//create resource route for ReviewController
Route::resource('reviews', 'ReviewController');

//create resource route for MapController
Route::resource('maps', 'MapController');

//Create resource route for HelpController
Route::resource('helps', 'HelpController', ['except' => ['create']]);
Route::get('helps/checkin/code', 'HelpController@checkincode')->name('checkincode');
Route::get('contact', 'HelpController@getContact')->name('getcontact');
Route::post('contact', 'HelpController@postContact')->name('postcontact');
Route::get('contact/host/{host}', 'HelpController@getContactHost')->name('getcontacthost');
Route::post('contact/host', 'HelpController@postContactHost')->name('postcontacthost');

//Check Database Connection
Route::get('check-connect',function(){
	if(DB::connection()->getDatabaseName()){
		return "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
	}else{
		return 'Connection False !!';
	}
});