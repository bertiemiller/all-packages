<?php

Route::group([
    'namespace'  => 'Topicmine\Content\Controllers',
    'middleware' => 'auth',
], function()
{
    Route::get('admin/analytics/dashboard', 'Admin\AnalyticsHomeController@index')->name('topicmine.analytics.dashboard.index');
    Route::get('admin/analytics', function ()
    {
        return redirect('admin/analytics/dashboard');
    });
});