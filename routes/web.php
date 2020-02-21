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
    return view('welcome');
});

Route::get('/country', function () {
    return view('countries',['countries'=> \App\Country::all()]);
})->name('countries');

Route::get('/country/{country}', function (\App\Country $country) {
    return view('country',compact('country'));
})->name('country');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
