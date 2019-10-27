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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::resource('/user','UserController');
Route::resource('/role','RoleController');
Route::resource('/letter','LetterController');
Route::get('/letters/child','LetterController@childLetter')->name('letter.child');
Route::get('/letters/access','LetterController@accessLetter')->name('letter.access');


