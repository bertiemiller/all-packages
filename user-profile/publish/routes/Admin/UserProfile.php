<?php

Route::group([
    'namespace'  => 'Topicmine\UserProfile\Controllers',
    'prefix'     => 'admin',
    'middleware' => ['admin'],
//    'middleware' => 'users.routeNeedsPermission:view-users-management',
], function ()
{
    Route::group(['prefix' => 'account/user-profile',], function ()
    {
        Route::get('/', function ()
        {
            return redirect()->route('topicmine.user_profile.dashboard.index');
        });

        Route::get('dashboard', 'DashboardController@index')
            ->name('topicmine.user_profile.dashboard.index');

        Route::get('password/change', 'ChangePasswordController@edit')
            ->name('topicmine.user_profile.password.edit');
        Route::post('password/change', 'ChangePasswordController@update')
            ->name('topicmine.user_profile.password.update');

        createRoutes([
            [
                'namespace'  => 'topicmine.user_profile',
                'routeBase'  => 'contact',
                'controller' => 'ContactController',
            ]
        ]);
        createRoutes([
            [
                'namespace'  => 'topicmine.user_profile',
                'routeBase'  => 'domain',
                'controller' => 'DomainController',
            ]
        ]);
    });
});