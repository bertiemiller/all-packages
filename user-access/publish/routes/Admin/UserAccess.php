<?php

Route::group([
    'namespace' => 'Topicmine\UserAccess\Controllers',
    'prefix' => 'admin',
    'middleware' => ['admin'],
//    'middleware' => 'users.routeNeedsPermission:view-users-management',
], function ()
{

    Route::group(['prefix' => 'account/user-access'], function ()
    {
        Route::get('/', function ()
        {
            return redirect()->route('topicmine.user_access.dashboard.index');
        });

        Route::get('dashboard', 'DashboardController@index')
            ->name('topicmine.user_access.dashboard.index');

        createRoutes([
            [
                'namespace'  => 'topicmine.user_access',
                'routeBase'  => 'user',
                'controller' => 'UserController',
            ]
        ]);

        createRoutes([
            [
                'namespace'  => 'topicmine.user_access',
                'routeBase'  => 'role',
                'controller' => 'RoleController',
            ]
        ]);

        createRoutes([
            [
                'namespace'  => 'topicmine.user_access',
                'routeBase'  => 'permission',
                'controller' => 'PermissionController',
            ]
        ]);

        createRoutes([
            [
                'namespace'  => 'topicmine.user_access',
                'routeBase'  => 'permission-group',
                'controller' => 'PermissionGroupController',
            ]
        ]);

    });


});