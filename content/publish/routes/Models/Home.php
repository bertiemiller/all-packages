<?php

Route::group([
    'namespace'  => 'Topicmine\Content\Controllers',
    'middleware' => 'auth',
], function()
{
    Route::get('admin/models/dashboard', 'Admin\ModelsHomeController@index')->name('topicmine.models.dashboard.index');
    Route::get('admin/models', function ()
    {
        return redirect('admin/models/dashboard');
    });
});