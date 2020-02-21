<?php

use Hyn\Tenancy\Environment;

Route::group(['prefix' => ''], function () {

    Route::get('/country/{country}', function (\App\Country $country) {
        return view('country',compact('country'));
    })->name('country');

    Route::get('/staff', 'StaffController@index')->name('staff');

});
