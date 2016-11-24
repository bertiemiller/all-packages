<?php

Route::group([
    'namespace'  => 'Topicmine\Content\Controllers',
    'middleware' => 'auth',
], function()
{
    Route::get('admin/sources/dashboard', 'Admin\SourcesHomeController@index')->name('topicmine.sources.dashboard.index');
    Route::get('admin/sources', function ()
    {
        return redirect('admin/sources/dashboard');
    });
});