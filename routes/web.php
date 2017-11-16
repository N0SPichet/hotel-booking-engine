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

//Create PagesController Route
Route::get('/home', 'PagesController@index')->name('home');
Route::get('mytrips', 'PagesController@mytrip')->name('mytrips');
Route::get('diaries/mydiaries', 'PagesController@mydiaries')->name('diaries.mydiaries');
Route::get('diary/{id}', 'PagesController@single')->name('diary.single');
Route::get('user/profile', 'PagesController@userprofile')->name('users.profile');
Route::get('about-us', 'PagesController@aboutus')->name('aboutus');


//Create resource route for UserController
Route::resource('users', 'UserController');
Route::post('user/{id}/updateimage', 'UserController@updateimage')->name('users.updateimage');
Route::post('users/{id}/report', 'UserController@ureport')->name('users.report');
Route::get('users/{id}/description', 'UserController@description')->name('users.description');

//Create resource route for RentalController
Route::resource('rentals', 'RentalController');
Route::post('rentals/agreement', 'RentalController@rentals_agreement')->name('rentals.agreement');
Route::post('rentals/{id}/acceptnew', 'RentalController@acceptnew')->name('rentals.acceptnew');
Route::get('rentals/mr/rentmyrooms', 'RentalController@rmyrooms')->name('rentals.rmyrooms');
Route::get('rentals/mr/histories', 'RentalController@rhistories')->name('rentals.rhistories');
Route::post('checkin/code/check', 'RentalController@checkcode')->name('checkin.code');
Route::post('rentals/{id}/approve', 'RentalController@rapproved')->name('rentals.approve');
Route::post('mytrips/{id}/cancel', 'RentalController@rcancel')->name('rental.rentalcancel');
Route::post('rentals/{id}/reject', 'RentalController@rejecttrip')->name('rentals.reject');

//Create resource route for DiaryController
Route::resource('diaries', 'DiaryController');

//Create resource route for CategoryController
Route::resource('categories', 'CategoryController', ['except' => ['create']]);

//Create resource route for TagController
Route::resource('tags', 'TagController', ['except' => ['create']]);

//Create resource route for CommentController
Route::resource('comments', 'CommentController');
Route::get('comments/{id}/delete', 'CommentController@delete')->name('comments.delete');

//Create resource route for HouseitemController
Route::resource('houseamenities', 'HouseamenityController', ['except' => ['create']]);

//Create resource route for RoomController
Route::resource('rooms', 'RoomController');
Route::post('rooms/setscene', 'RoomController@rsetscene')->name('rooms.setscene');
Route::post('rooms/finalstep', 'RoomController@rfinalstep')->name('rooms.finalstep');
Route::get('rooms/myroom/{id}', 'RoomController@indexmyroom')->name('index-myroom');
Route::get('room/{id}', 'RoomController@single')->name('rooms.single');
Route::get('room/{id}/delete/image', 'RoomController@detroyimage')->name('rooms.detroyimage');

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
