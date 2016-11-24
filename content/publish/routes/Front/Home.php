<?php
Route::group([
    'namespace'  => 'Topicmine\Content\Controllers',
], function ()
{
    Route::get('/', 'FrontHomeController@index')->name('home');

    Route::get('home', function ()
    {
        return redirect('/');
    });

});