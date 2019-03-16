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

//Landing
Route::get('/', 'PagesController@index');
Route::get('/home', 'PagesController@index')->name('home');
Route::post('/search', 'PagesController@indexSearch')->name('search');

//Admin Section
Route::prefix('admin')->group(function() {
	//Landing
	Route::get('/', 'Backends\AdminController@index')->name('admin.home');
	Route::get('dashboard', 'Backends\AdminController@index')->name('admin.dashboard');
	//Auth
	Route::get('register', 'Backends\AdminController@create')->name('admin.register');
	Route::post('register', 'Backends\AdminController@store')->name('admin.register.store');
	Route::get('login', 'Backends\Auth\LoginController@login')->name('admin.auth.login');
	Route::post('login', 'Backends\Auth\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
	Route::post('logout', 'Backends\Auth\LoginController@logout')->name('admin.auth.logout');
	//Components
	Route::prefix('components')->name('comp.')->group(function() {
		/*Diary Component*/
		Route::prefix('categories')->name('categories.')->group(function() {
			Route::get('/', 'Backends\DiaryComponentController@categories_index')->name('index');
			Route::post('store', 'Backends\DiaryComponentController@categories_store')->name('store');
			Route::get('show/{category}', 'Backends\DiaryComponentController@categories_show')->name('show');
			Route::get('edit/{category}', 'Backends\DiaryComponentController@categories_edit')->name('edit');
			Route::put('update/{category}', 'Backends\DiaryComponentController@categories_update')->name('update');
			Route::delete('destroy/{category}', 'Backends\DiaryComponentController@categories_destroy')->name('destroy');
		});
		Route::prefix('tags')->name('tags.')->group(function() {
			Route::get('/', 'Backends\DiaryComponentController@tags_index')->name('index');
			Route::post('store', 'Backends\DiaryComponentController@tags_store')->name('store');
			Route::get('show/{tag}', 'Backends\DiaryComponentController@tags_show')->name('show');
			Route::get('edit/{tag}', 'Backends\DiaryComponentController@tags_edit')->name('edit');
			Route::put('update/{tag}', 'Backends\DiaryComponentController@tags_update')->name('update');
			Route::delete('destroy/{tag}', 'Backends\DiaryComponentController@tags_destroy')->name('destroy');
		});
		/*Room Component*/
		Route::prefix('amenities')->name('amenities.')->group(function() {
			Route::get('/', 'Backends\RoomComponentController@amenities_index')->name('index');
			Route::post('store', 'Backends\RoomComponentController@amenities_store')->name('store');
			Route::get('show/{amenity}', 'Backends\RoomComponentController@amenities_show')->name('show');
			Route::get('edit/{amenity}', 'Backends\RoomComponentController@amenities_edit')->name('edit');
			Route::put('update/{amenity}', 'Backends\RoomComponentController@amenities_update')->name('update');
			Route::delete('destroy/{amenity}', 'Backends\RoomComponentController@amenities_destroy')->name('destroy');
		});
		Route::prefix('details')->name('details.')->group(function() {
			Route::get('/', 'Backends\RoomComponentController@details_index')->name('index');
			Route::post('store', 'Backends\RoomComponentController@details_store')->name('store');
			Route::get('show/{detail}', 'Backends\RoomComponentController@details_show')->name('show');
			Route::get('edit/{detail}', 'Backends\RoomComponentController@details_edit')->name('edit');
			Route::put('update/{detail}', 'Backends\RoomComponentController@details_update')->name('update');
			Route::delete('destroy/{detail}', 'Backends\RoomComponentController@details_destroy')->name('destroy');
		});
		Route::prefix('rules')->name('rules.')->group(function() {
			Route::get('/', 'Backends\RoomComponentController@rules_index')->name('index');
			Route::post('store', 'Backends\RoomComponentController@rules_store')->name('store');
			Route::get('show/{rule}', 'Backends\RoomComponentController@rules_show')->name('show');
			Route::get('edit/{rule}', 'Backends\RoomComponentController@rules_edit')->name('edit');
			Route::put('update/{rule}', 'Backends\RoomComponentController@rules_update')->name('update');
			Route::delete('destroy/{rule}', 'Backends\RoomComponentController@rules_destroy')->name('destroy');
		});
	});
	/*Apartments*/
	Route::prefix('apartments')->name('admin.apartments.')->group(function() {
		Route::get('/', 'Backends\ApartmentController@index')->name('index');
		Route::get('{house}/as-owner', 'Backends\ApartmentController@as_owner')->name('as-owner');
	});
	/*Rooms*/
	Route::prefix('rooms')->name('admin.rooms.')->group(function() {
		Route::get('/', 'Backends\RoomController@index')->name('index');
		Route::get('{house}/as-owner', 'Backends\RoomController@as_owner')->name('as-owner');
	});
	/*Rentals*/
	Route::prefix('rentals')->name('admin.rentals.')->group(function() {
		Route::get('/', 'Backends\RentalController@index')->name('index');
		Route::get('{rental}', 'Backends\RentalController@show')->name('show');
		Route::post('{rental}/approve', 'Backends\RentalController@rental_approve')->name('approve');
		Route::post('{rental}/reject', 'Backends\RentalController@rental_reject')->name('reject');
	});
	/*Users*/
	Route::prefix('users')->name('admin.users.')->group(function() {
		Route::get('/', 'Backends\UserController@index')->name('index');
		Route::get('{user}', 'Backends\UserController@show')->name('show');
		Route::post('{user}/block', 'Backends\UserController@block')->name('block');
		Route::get('all/verification', 'Backends\UserController@verify_index')->name('verify-index');
		Route::get('{user}/verification', 'Backends\UserController@verify_show')->name('verify-show');
		Route::post('{user}/verification/approve', 'Backends\UserController@verify_approve')->name('verify-approve');
		Route::post('{user}/verification/reject', 'Backends\UserController@verify_reject')->name('verify-reject');
	});
});

//Create PagesController Route
Route::get('about-us', 'PagesController@aboutus')->name('aboutus');
Route::prefix('dashboard')->name('dashboard.')->group(function() {
	Route::get('', 'PagesController@dashboard_index')->name('index');
	Route::get('diaries', 'PagesController@dashboard_diaries_index')->name('diaries.index');
	Route::get('trips', 'PagesController@dashboard_trips_index')->name('trips.index');
	Route::get('hosts', 'PagesController@dashboard_hosts_index')->name('hosts.index');
	Route::get('rentals', 'PagesController@dashboard_rentals_index')->name('rentals.index');
	Route::get('summary', 'PagesController@dashboard_summary_index')->name('summary.index');
	Route::get('account', 'PagesController@dashboard_account_index')->name('account.index');
	Route::get('{user}/rooms/online', 'PagesController@dashboard_rooms_online')->name('rooms.online');
	Route::get('{user}/rooms/offline', 'PagesController@dashboard_rooms_offline')->name('rooms.offline');
	Route::get('{user}/apartments/online', 'PagesController@dashboard_apartments_online')->name('apartments.online');
	Route::get('{user}/apartments/offline', 'PagesController@dashboard_apartments_offline')->name('apartments.offline');
});

//Create resource route for UserController
Route::resource('users', 'UserController');
Route::prefix('users')->name('users.')->group(function () {
	Route::get('{user}/description', 'UserController@description')->name('description');
	Route::get('{user}/profile', 'UserController@userprofile')->name('profile');
	Route::get('{user}/verify', 'UserController@verify_user')->name('verify-user');
	Route::post('{user}/updateimage', 'UserController@updateimage')->name('updateimage');
	Route::post('verification/send_request', 'UserController@verify_request')->name('verify-request');
});

//Create resource route for DiaryController
Route::resource('diaries', 'DiaryController');
Route::prefix('diaries')->name('diaries.')->group(function() {
	Route::get('mydiaries/{user}', 'DiaryController@mydiaries')->name('mydiaries');
	Route::get('{diary}/single', 'DiaryController@single')->name('single');
	Route::get('{user}/subscribe', 'DiaryController@subscribe')->name('subscribe');
	Route::post('{user}/unsubscribe', 'DiaryController@unsubscribe')->name('unsubscribe');
	Route::get('{rental}/trips/{user}', 'DiaryController@tripdiary')->name('tripdiary');
	Route::get('{rental}/trips/{user}/day/{day}/edit', 'DiaryController@tripdiary_edit')->name('tripdiary.edit');
	Route::put('trips-diary/{diary}/update', 'DiaryController@tripdiary_update')->name('tripdiary.update');
	Route::delete('trips-diary/{rental}/delete', 'DiaryController@tripdiary_destroy')->name('tripdiary.destroy');
	Route::get('image/{image}/delete', 'DiaryController@detroyimage')->name('detroyimage');
	Route::get('{diary}/temp-delete', 'DiaryController@temp_delete')->name('temp.delete');
	Route::get('{diary}/restore', 'DiaryController@restore')->name('restore');
});

//Create resource route for CommentController
Route::resource('comments', 'CommentController');
Route::prefix('comments')->name('comments.')->group(function() {
	Route::get('{comment}/delete', 'CommentController@delete')->name('delete');
});

//Create route for hosts
Route::prefix('hosts')->name('hosts.')->group(function() {
	Route::get('introduction-hosting-room', 'PagesController@introroom')->name('introroom');
	Route::get('introduction-hosting-apartment', 'PagesController@introapartment')->name('introapartment');
});

//Create resource route for ApartmentController
Route::resource('apartments', 'ApartmentController');
Route::prefix('apartments')->name('apartments.')->group(function() {
	Route::get('{house}/owner', 'ApartmentController@owner')->name('owner');
	Route::get('image/{image}/delete', 'ApartmentController@detroyimage')->name('detroyimage');
});

//Create resource route for RoomController
Route::resource('rooms', 'RoomController');
Route::prefix('rooms')->name('rooms.')->group(function() {
	Route::get('{house}/owner', 'RoomController@owner')->name('owner');
	Route::get('{house}/owner/temp-delete', 'RoomController@temp_delete')->name('temp.delete');
	Route::put('{house}/owner/permanent-delete', 'RoomController@permanent_delete')->name('permanent.delete');
	Route::get('{house}/owner/restore', 'RoomController@restore')->name('restore');
	Route::get('image/{image}/delete', 'RoomController@detroyimage')->name('detroyimage');
});

//Create resource route for RentalController
Route::resource('rentals', 'RentalController');
Route::prefix('rentals')->name('rentals.')->group(function() {
	Route::post('booking/agreement', 'RentalController@rentals_agreement')->name('agreement');
	Route::get('booking/preview', 'RentalController@booking_preview')->name('booking.preview');
	Route::get('trips/{user}', 'RentalController@mytrip')->name('mytrips');
	Route::get('trips/{user}/not-review', 'RentalController@not_reviews')->name('notreviews');
	Route::get('trips/{user}/rentmyrooms', 'RentalController@rentmyrooms')->name('rentmyrooms');
	Route::get('trips/{user}/rentmyrooms/histories', 'RentalController@renthistories')->name('renthistories');
	Route::post('{rental}/accept-rentalrequest', 'RentalController@accept_rentalrequest')->name('accept-rentalrequest');
	Route::post('{rental}/reject-rentalrequest', 'RentalController@reject_rentalrequest')->name('reject-rentalrequest');
	Route::post('{rental}/cancel', 'RentalController@rental_cancel')->name('cancel');
	Route::post('checkin/confirmed', 'RentalController@checkin_confirmed')->name('checkin.confirmed');
	Route::post('checkin/check', 'RentalController@checkin_check')->name('checkin');
});

//create resource route for ReviewController
Route::resource('reviews', 'ReviewController');

//create resource route for MapController
Route::resource('maps', 'MapController');

//Create resource route for HelpController
Route::prefix('helps')->name('helps.')->group(function() {
	Route::get('', 'HelpController@index')->name('index');
	Route::get('checkin', 'HelpController@checkincode')->name('checkincode');
	Route::get('contact', 'HelpController@getContact')->name('getcontact');
	Route::post('contact', 'HelpController@postContact')->name('postcontact');
	Route::get('contact/host/{house}', 'HelpController@getContactHost')->name('getcontacthost');
	Route::post('contact/host', 'HelpController@postContactHost')->name('postcontacthost');
});
