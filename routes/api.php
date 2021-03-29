<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['cors', 'token-auth'])->group(static function () {
    Route::get('me', function(){return \Illuminate\Support\Facades\Auth::user();});

    Route::post('departments/create', '\App\Http\Components\Department\Controllers\DepartmentController'.'@create');
    Route::put('departments/update/{department}', '\App\Http\Components\Department\Controllers\DepartmentController'.'@update');
    Route::delete('departments/delete/{department}', '\App\Http\Components\Department\Controllers\DepartmentController'.'@delete');

    Route::post('department-to-users/join', '\App\Http\Components\User\Controllers\DepartmentController'.'@join');
    Route::delete('department-to-users/detach/{dtu}', '\App\Http\Components\User\Controllers\DepartmentController'.'@detach');

    Route::post('upload-files', 'UploadController@upload');
    Route::post('delete-files', 'UploadController@delete');

    Route::post('password-update', '\App\Http\Components\User\Controllers\PasswordController'.'@update');
    Route::post('logout', '\App\Http\Components\User\Controllers\AuthController'.'@logout');

    Route::get('get-users/{role}', '\App\Http\Components\User\Controllers\UserController'.'@get');
    Route::post('edit-user', '\App\Http\Components\User\Controllers\UserController'.'@edit');
    Route::post('create-user', '\App\Http\Components\User\Controllers\UserController'.'@create');
    Route::put('update-email-request', '\App\Http\Components\User\Controllers\EmailController'.'@request');
    Route::put('update-email-confirm', '\App\Http\Components\User\Controllers\EmailController'.'@confirm');
    Route::put('update-phone-request', '\App\Http\Components\User\Controllers\MobilePhoneController'.'@request');
    Route::put('update-phone-confirm', '\App\Http\Components\User\Controllers\MobilePhoneController'.'@confirm');

    Route::put('edit-settings', '\App\Http\Components\Settings\Controllers\SystemSettingController'.'@update');


    Route::get('test-sms/{phone}/{message}', 'TestController'.'@testSms');
    Route::get('test-email/{email}/{message}', 'TestController'.'@testEmail');
});

Route::middleware(['cors', 'token-auth:false'])->group(static function () {
    Route::get('get-settings', '\App\Http\Components\Settings\Controllers\SystemSettingController'.'@get');
});

Route::middleware(['cors'])->group(static function () {
    Route::get('departments/get-all', '\App\Http\Components\Department\Controllers\DepartmentController'.'@getAll');
    Route::get('departments/get-by-id/{id}', '\App\Http\Components\Department\Controllers\DepartmentController'.'@get');

    Route::post('sign-up-request', '\App\Http\Components\User\SignUpController'.'@request');
    Route::post('sign-up-confirm', '\App\Http\Components\User\SignUpController'.'@confirm');
    Route::post('code-resent', '\App\Http\Components\User\SignUpController'.'@codeResent');

    Route::post('login', '\App\Http\Components\User\AuthController'.'@login');
    Route::post('refresh-token', '\App\Http\Components\User\AuthController'.'@refreshToken');

    Route::post('password-reset-request', '\App\Http\Components\User\PasswordController'.'@reset');
    Route::post('password-reset-confirm', '\App\Http\Components\User\PasswordController'.'@confirm');
});


