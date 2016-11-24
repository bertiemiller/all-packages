<?php

Route::group([
    'namespace'  => 'Topicmine\Content\Controllers',
], function ()
{
    Route::get('contact', function ()
    {
        return view('front.statics.contact');
    })->name('topicmine.front_content.contact');

    Route::get('demo', function ()
    {
        return view('front.statics.demo');
    })->name('topicmine.front_content.demo');

// regex ensures admin routes do not match
    Route::get('{page}', 'FrontContentController@index')
        ->name('topicmine.front_content.content.page')
        ->where('page', '^(?!admin).+');
    Route::get('{category}/{page}', 'FrontContentController@showCategoryPage')
        ->name('topicmine.front_content.content.showCategoryPage')
        ->where('category', '^(?!admin).+');
    Route::get('{category}/{subCategory}/{page}', 'FrontContentController@showSubCategoryPage')
        ->name('topicmine.front_content.content.showSubCategoryPage')
        ->where('category', '^(?!admin).+');

});