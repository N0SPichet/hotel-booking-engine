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
Route::prefix('manages')->name('manages.')->group(function() {
	Route::get('{user}', 'PagesController@manages_index')->name('index');
	Route::get('{user}/rooms/online', 'PagesController@manages_rooms_online')->name('rooms.online');
	Route::get('{user}/rooms/offline', 'PagesController@manages_rooms_offline')->name('rooms.offline');
	Route::get('{user}/apartments/online', 'PagesController@manages_apartments_online')->name('apartments.online');
	Route::get('{user}/apartments/offline', 'PagesController@manages_apartments_offline')->name('apartments.offline');
});

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
	Route::get('{diary}/temp-delete', 'DiaryController@temp_delete')->name('temp.delete');
	Route::get('{diary}/restore', 'DiaryController@restore')->name('restore');
});

//Create resource route for CommentController
Route::resource('comments', 'CommentController');
Route::prefix('comments')->name('comments.')->group(function() {
	Route::get('{comment}/delete', 'CommentController@delete')->name('delete');
});

Route::prefix('components')->name('comp.')->group(function() {
	/*Diary Component*/
	Route::prefix('categories')->name('categories.')->group(function() {
		Route::get('/', 'DiaryComponentController@categories_index')->name('index');
		Route::post('store', 'DiaryComponentController@categories_store')->name('store');
		Route::get('show/{category}', 'DiaryComponentController@categories_show')->name('show');
		Route::get('edit/{category}', 'DiaryComponentController@categories_edit')->name('edit');
		Route::put('update/{category}', 'DiaryComponentController@categories_update')->name('update');
		Route::delete('destroy/{category}', 'DiaryComponentController@categories_destroy')->name('destroy');
	});
	Route::prefix('tags')->name('tags.')->group(function() {
		Route::get('/', 'DiaryComponentController@tags_index')->name('index');
		Route::post('store', 'DiaryComponentController@tags_store')->name('store');
		Route::get('show/{tag}', 'DiaryComponentController@tags_show')->name('show');
		Route::get('edit/{tag}', 'DiaryComponentController@tags_edit')->name('edit');
		Route::put('update/{tag}', 'DiaryComponentController@tags_update')->name('update');
		Route::delete('destroy/{tag}', 'DiaryComponentController@tags_destroy')->name('destroy');
	});
	/*Room Component*/
	Route::prefix('amenities')->name('amenities.')->group(function() {
		Route::get('/', 'RoomComponentController@amenities_index')->name('index');
		Route::post('store', 'RoomComponentController@amenities_store')->name('store');
		Route::get('show/{amenity}', 'RoomComponentController@amenities_show')->name('show');
		Route::get('edit/{amenity}', 'RoomComponentController@amenities_edit')->name('edit');
		Route::put('update/{amenity}', 'RoomComponentController@amenities_update')->name('update');
		Route::delete('destroy/{amenity}', 'RoomComponentController@amenities_destroy')->name('destroy');
	});
	Route::prefix('details')->name('details.')->group(function() {
		Route::get('/', 'RoomComponentController@details_index')->name('index');
		Route::post('store', 'RoomComponentController@details_store')->name('store');
		Route::get('show/{detail}', 'RoomComponentController@details_show')->name('show');
		Route::get('edit/{detail}', 'RoomComponentController@details_edit')->name('edit');
		Route::put('update/{detail}', 'RoomComponentController@details_update')->name('update');
		Route::delete('destroy/{detail}', 'RoomComponentController@details_destroy')->name('destroy');
	});
	Route::prefix('rules')->name('rules.')->group(function() {
		Route::get('/', 'RoomComponentController@rules_index')->name('index');
		Route::post('store', 'RoomComponentController@rules_store')->name('store');
		Route::get('show/{rule}', 'RoomComponentController@rules_show')->name('show');
		Route::get('edit/{rule}', 'RoomComponentController@rules_edit')->name('edit');
		Route::put('update/{rule}', 'RoomComponentController@rules_update')->name('update');
		Route::delete('destroy/{rule}', 'RoomComponentController@rules_destroy')->name('destroy');
	});
});

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
	Route::get('owner/{house}/temp-delete', 'RoomController@temp_delete')->name('temp.delete');
	Route::put('owner/{house}/permanent-delete', 'RoomController@permanent_delete')->name('permanent.delete');
	Route::get('owner/{house}/restore', 'RoomController@restore')->name('restore');
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
Route::prefix('helps')->name('helps.')->group(function() {
	Route::get('', 'HelpController@index')->name('index');
	Route::get('checkin/code', 'HelpController@checkincode')->name('checkincode');
	Route::get('contact', 'HelpController@getContact')->name('getcontact');
	Route::post('contact', 'HelpController@postContact')->name('postcontact');
	Route::get('contact/host/{house}', 'HelpController@getContactHost')->name('getcontacthost');
	Route::post('contact/host', 'HelpController@postContactHost')->name('postcontacthost');
});
