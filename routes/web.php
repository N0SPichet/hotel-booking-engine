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
Route::get('/home', 'PagesController@index')->name('home');
Route::post('/search', 'PagesController@indexSearch')->name('search');

//Create PagesController Route
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

//Create resource route for DiaryController
Route::resource('diaries', 'DiaryController');
Route::prefix('diaries')->name('diaries.')->group(function() {
	Route::get('mydiaries/{user}', 'DiaryController@mydiaries')->name('mydiaries');
	Route::get('{diary}/single', 'DiaryController@single')->name('single');
	Route::post('{user}/subscribe', 'DiaryController@subscribe')->name('subscribe');
	Route::post('{user}/unsubscribe', 'DiaryController@unsubscribe')->name('unsubscribe');
	Route::get('{rental}/trips/{user}', 'DiaryController@tripdiary')->name('tripdiary');
	Route::get('{rental}/trips/{user}/day/{day}/edit', 'DiaryController@tripdiary_edit')->name('tripdiary.edit');
	Route::put('trips-diary/{diary}/update', 'DiaryController@tripdiary_update')->name('tripdiary.update');
	Route::get('trips-diary/{diary}/delete', 'DiaryController@tripdiary_destroy')->name('tripdiary.destroy');
	Route::get('image/{image}/delete', 'DiaryController@detroyimage')->name('detroyimage');
});

//Create resource route for CategoryController
Route::resource('categories', 'CategoryController', ['except' => ['create']]);

//Create resource route for TagController
Route::resource('tags', 'TagController', ['except' => ['create']]);

//Create resource route for CommentController
Route::resource('comments', 'CommentController');
Route::prefix('comments')->name('comments.')->group(function() {
	Route::get('{comment}/delete', 'CommentController@delete')->name('delete');
});

//Create resource route for HouseitemController
Route::resource('houseamenities', 'HouseamenityController', ['except' => ['create']]);

//Create route for hosts
Route::prefix('hosts')->name('hosts.')->group(function() {
	Route::get('introduction-hosting-room', 'PagesController@introroom')->name('introroom');
	Route::get('introduction-hosting-apartment', 'PagesController@introapartment')->name('introapartment');
});

//Create resource route for ApartmentController
Route::resource('apartments', 'ApartmentController');
Route::prefix('apartments')->name('apartments.')->group(function() {
	Route::get('my-apartment/{user}', 'ApartmentController@index_myapartment')->name('index-myapartment');
	Route::get('owner/{house}', 'ApartmentController@owner')->name('owner');
	Route::get('image/{image}/delete', 'ApartmentController@detroyimage')->name('detroyimage');
});

//Create resource route for RoomController
Route::resource('rooms', 'RoomController');
Route::prefix('rooms')->name('rooms.')->group(function() {
	Route::get('my-room/{user}', 'RoomController@index_myroom')->name('index-myroom');
	Route::get('owner/{house}', 'RoomController@owner')->name('owner');
	Route::get('image/{image}/delete', 'RoomController@detroyimage')->name('detroyimage');
});

//Create resource route for RentalController
Route::resource('rentals', 'RentalController');
Route::prefix('rentals')->name('rentals.')->group(function() {
	Route::post('agreement', 'RentalController@rentals_agreement')->name('agreement');
	Route::get('trips/{user}', 'RentalController@mytrip')->name('mytrips');
	Route::get('trips/{user}/not-review', 'RentalController@not_reviews')->name('notreviews');
	Route::get('trips/{user}/rentmyrooms', 'RentalController@rentmyrooms')->name('rentmyrooms');
	Route::post('{rental}/accept-rentalrequest', 'RentalController@accept_rentalrequest')->name('accept-rentalrequest');
	Route::post('{rental}/reject-rentalrequest', 'RentalController@reject_rentalrequest')->name('reject-rentalrequest');
	Route::post('{rental}/approve', 'RentalController@rental_approve')->name('approve');
	Route::post('{rental}/cancel', 'RentalController@rental_cancel')->name('cancel');
	Route::post('{rental}/reject', 'RentalController@rental_reject')->name('reject');
	Route::post('checkin/check', 'RentalController@checkcode')->name('checkin.code');
	Route::get('trips/{user}/rentmyrooms/histories', 'RentalController@renthistories')->name('renthistories');
});

//create resource route for ReviewController
Route::resource('reviews', 'ReviewController');

//create resource route for MapController
Route::resource('maps', 'MapController');

//Create resource route for HelpController
Route::get('helps', 'HelpController@index')->name('helps.index');
Route::get('helps/checkin/code', 'HelpController@checkincode')->name('checkincode');
Route::get('contact', 'HelpController@getContact')->name('getcontact');
Route::post('contact', 'HelpController@postContact')->name('postcontact');
Route::get('contact/host/{host}', 'HelpController@getContactHost')->name('getcontacthost');
Route::post('contact/host', 'HelpController@postContactHost')->name('postcontacthost');
