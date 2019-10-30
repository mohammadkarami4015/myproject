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




Route::middleware('auth')-> group(function (){
    Route::get('/', function () {
        return view('home');
    });
    Route::resource('/user','UserController');
    Route::resource('/role','RoleController');
    Route::resource('/letter','LetterController');

    Route::patch('/users/updateRole/{user}','UserController@updateRole')->name('user.updateRole');
    Route::get('/users/child','UserController@childUser')->name('user.child');
    Route::get('/users/editProfile/{user}','UserController@editProfile')->name('user.editProfile');
    Route::patch('/users/updateProfile/{user}','UserController@updateProfile')->name('user.updateProfile');

    Route::get('/letters/child','LetterController@childLetter')->name('letter.child');
    Route::get('/letters/myIndex','LetterController@myIndex')->name('letter.myIndex');
    Route::get('/letters/access','LetterController@accessLetter')->name('letter.access');
});



Route::group(['namespace' => 'Auth'] , function (){
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
});
