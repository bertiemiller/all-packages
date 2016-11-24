<?php

Route::group([
    'namespace'  => 'Topicmine\Subscription\Controllers',
    'prefix' => 'admin/account',
    'middleware' => ['admin'],
//    'middleware' => 'users.routeNeedsPermission:view-admin',
], function() {

    Route::group(['prefix'     => 'subscription'], function() {

        Route::get('/', function ()
        {
            return redirect()->route('topicmine.subscription.dashboard.index');
        });

        Route::get('dashboard', 'DashboardController@index')
            ->name('topicmine.subscription.dashboard.index');

        Route::get('invoices', 'PurchaseController@index')
            ->name('topicmine.subscription.purchase.index');
        Route::get('invoices/{id}', 'PurchaseController@printInvoice')
            ->name('topicmine.subscription.purchase.printInvoice');

        Route::get('cancel', 'CancellationController@index')
            ->name('topicmine.subscription.cancellation.index');
        Route::post('cancel', 'CancellationController@cancel')
            ->name('topicmine.subscription.cancellation.cancel');

    });

    // must be below the other routes
    createRoutes([
        [
            'namespace' => 'topicmine.subscription',
            'routeBase' => 'subscription',
            'controller' => 'SubscriptionController',
        ]
    ]);

});

