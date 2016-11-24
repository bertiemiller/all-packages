<?php

Route::group([
    'namespace'  => 'Topicmine\Content\Controllers',
    'middleware' => 'auth',
], function()
{
    Route::get('admin/dashboard', 'Admin\AdminHomeController@index')
        ->name('topicmine.admin.dashboard.index');

    Route::get('admin', function ()
    {
        return redirect()->route('topicmine.admin.dashboard.index');
    });

});