<?php
use Illuminate\Support\Facades\Auth;

/**
 * Frontend routes
 */

Route::get('/', function () {
	return view('index');
})->name('/');

Route::get('/home', function () {
	return view("home");
});

Route::get('/guideline', function () {
	return view('guideline');
})->name('guideline');

Route::get('sign-up', 'User\AuthController@showSignUpForm')->name('user.sign-up');

Route::post('sign-up', 'User\AuthController@register')->name('user.register');

Route::get('forgot-password', function () {
	return view('users/user-reset-pw');
})->name('user.forgot-password');

Route::post('forgot-password','User\AuthController@updateResetPw')->name('user.update-reset-password');

Route::get('user-login', [
	'as' => 'user-login',
	'uses' => 'User\AuthController@showLoginForm'
]);

Route::post('login', 'User\AuthController@login')->name('user.login');

Route::post('user-logout', [
	'as' => 'user-logout',
	'uses' => 'User\AuthController@logout'
	]);

Route::get('user/activation/{token}' , 'User\AuthController@userActivation');

Route::get('cityNameAjax', 'User\AuthController@cityNameAjax');

//auth user route
Route::middleware(['auth','user'])->group(function() {

	Route::get('/profile', function(){ return view('users.user-profile'); });
	Route::post('profile', 'UserController@UserProfile')->name('user.profile');
	Route::get('changePassword', 'UserController@changePassword');
	Route::post('changePassword', 'UserController@updatePassword')->name('user.updatePassword');
	Route::get('profile/bookingList', 'UserController@booking');
	Route::get('exportPdf/pdf/{app_id}', 'DynamicPdfController@exportPdf');
	
	// etoken appointment routes
	Route::get('cosmetic/appoint_new/{id}', 'CosmeticController@new');
	Route::get('catTypeAjax', 'CosmeticController@getDateByCatType');
	Route::get('getAvailableItemAjax', 'CosmeticController@getAvailableItem');
	Route::get('cosmetic/appoint_resend', 'CosmeticController@resend')->name('cosmetic.appoint_resend');
	Route::get('etoken/cancelAppointmentList/{dept_id}', 'CosmeticController@cancel'); //cancel list by department id
	Route::get('etoken/cancelAppointment/{app_id}', 'CosmeticController@cancelAppointment');//cancel with appointment id

	//control block users  route
	Route::middleware(['blockuser'])->group(function (){
		Route::post('cosmetic/appoint_new', 'CosmeticController@store')->name('cosmetic.appoint_new');
	});

		

});


/**
 * Dashboard routes.
 */
Route::prefix(config('app.admin_prefix'))->group(function () // sample 'admin'
{
	Auth::routes(['register' => false]);

	Route::middleware(['auth', 'superadmin'])->group(function () {

		Route::get('/', 'Admin\DashboardController@index')->name('admin.index');

		Route::resource('users', 'Admin\UserController', ['as' => 'admin']);

		Route::post('import', 'Admin\UserController@import')->name("import_users");
		
		Route::get('export', 'Admin\UserController@export')->name('export_users');

		Route::resource('front_end_users', 'Admin\FrontEndUserController', ['as' => 'admin']);

		Route::resource('blocks', 'Admin\BlockController', ['as' => 'admin']);

		Route::post('ajax/companyRegId','Admin\UserController@getCompanyRegId');

		Route::resource('tokens', 'Admin\TokenController', ['as' => 'admin']);

		Route::get('tokens/{date}/{app_cat_id}/{slot_id}', 'Admin\TokenController@destroy')->name('admin.etoken.destroy');

		Route::get('admin/tokens/search', 'Admin\TokenController@search')->name('search_token');

		Route::get('tokens/datesearch/{a}/{b}/{c}', 'Admin\TokenController@show');

		Route::get('add-tokens-limit','Admin\TokenController@addTokenLimitForm')->name('add_token_limit_form');

		Route::get('catType', 'Admin\TokenController@getTimeSlot')->name('get_time_slot');

		Route::post('update-token-limit','Admin\TokenController@updateTokenLimit')->name('update_token_limit');

		Route::get('appointmentList', 'Admin\AppointmentController@index')->name('appointment_list');

		Route::get('appointmentExport', 'Admin\AppointmentController@export')->name('appointment_export');

		Route::get('appointmentCancelList', 'Admin\AppointmentController@cancel')->name('appointment_cancel');

		Route::get("appointmentCancel/{app_id}", 'Admin\AppointmentController@appointmentCancel')->name('cancel_appointment_by_admin');

		Route::get("appointment", 'Admin\AppointmentController@appointmentSearch')->name('appointment.search_appointment');

	});
});


