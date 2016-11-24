<?php

Route::group([
    'namespace'  => 'Topicmine\Content\Controllers',
    'middleware' => 'auth',
], function()
{
    Route::get('admin/account/dashboard', 'Admin\AccountHomeController@index')
        ->name('topicmine.account.dashboard.index');

    Route::get('admin/account', function ()
    {
        return redirect()->route('topicmine.account.dashboard.index');
    });

});
