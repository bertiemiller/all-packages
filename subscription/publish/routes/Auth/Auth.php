<?php

Route::group([
//    'prefix'     => 'account',
    'namespace' => 'Topicmine\Subscription\Controllers',
], function ()
{
    Route::post('login', 'Auth\LoginController@login', ['middleware' => 'cors']);
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');


    Route::get('register-subscription', 'Auth\RegisterSubscriptionController@showRegistrationSubscriptionForm')
        ->name('auth.register-subscription');
    Route::post('register-subscription', 'Auth\RegisterSubscriptionController@registerSubscription');
    Route::get('register/confirm', 'Auth\ConfirmUserController@showForm')
        ->name('auth.register.confirm');
    Route::post('register/confirm/resend-email', 'Auth\ConfirmUserController@resendEmail')
        ->name('auth.register.confirm.resendEmail');
    Route::get('register/confirm/{token}', 'Auth\ConfirmUserController@confirmToken')
        ->name('auth.register.confirm.token');
    Route::get('register/confirm/resend/{id}', 'Auth\ConfirmUserController@resendEmailToUser')
        ->name('auth.register.confirm.resendEmailToUser');

    Route::get('subscribe', function ()
    {
        flash('We are now going to take you through registration, payment and configuration.');

        return redirect('register-subscription');
    })->name('auth.subscribe');

    Route::get('register', function ()
    {
        flash('We are now going to take you through registration, payment and configuration.');

        return redirect('register-subscription');
    })->name('auth.subscribe');

});
