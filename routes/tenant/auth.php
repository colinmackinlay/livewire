<?php

Route::get('/staff/login', 'Auth\Staff\LoginController@showLoginForm')->name('staff.login');
Route::post('/staff/login', 'Auth\Staff\LoginController@login');
Route::post('/staff/logout', 'Auth\Staff\LoginController@logout')->name('staff.logout');
Route::get('/email/verify/{id}/{hash}', 'Auth\Staff\VerificationController@verify')->name('staff.verification.verify');

Route::get('/email/verify', 'Auth\Staff\VerificationController@show')->name('staff.verification.notice');
Route::get('/email/resend', 'Auth\Staff\VerificationController@resend')->name('staff.verification.resend');

Route::get('/staff/password/reset', 'Auth\Staff\ForgotPasswordController@showLinkRequestForm')->name('staff.password.request');
Route::post('/staff/password/email', 'Auth\Staff\ForgotPasswordController@sendResetLinkEmail')->name('staff.password.email');
Route::get('/staff/password/reset/{token}', 'Auth\Staff\ResetPasswordController@showResetForm')->name('staff.password.reset');
Route::post('/staff/password/reset', 'Auth\Staff\ResetPasswordController@reset')->name('staff.password.update');

Route::get('/', function () {
    if (\Hyn\Tenancy\Models\Hostname::where('fqdn', Request::getHttpHost())->exists())
    {
        return redirect(route('tenant.staff'));
    };

    return redirect(route('system.index'));
});

Route::get('/login', function () {

    if (\Hyn\Tenancy\Models\Hostname::where('fqdn', Request::getHttpHost())->exists())
    {
        return redirect(route('tenant.staff.login'));
    };

    return redirect(route('system.index'));
});

// redirect from system route provided by Spark when in a tenant
Route::get('/register', function () { return redirect('/');});
