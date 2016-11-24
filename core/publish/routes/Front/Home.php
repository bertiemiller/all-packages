<?php

Route::get('/', '\Topicmine\Core\Controllers\FrontHomeController@index')->name('home');
Route::get('home', function (){ return redirect('/'); });
