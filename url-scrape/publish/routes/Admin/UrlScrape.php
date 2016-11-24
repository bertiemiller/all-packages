<?php
// Urls
Route::group([
    'prefix' => 'admin/sources/url-scrape',
    'namespace'  => 'Topicmine\UrlScrape\Controllers',
], function ()
{
    Route::get('/', function ()
    {
        return redirect()->route('topicmine.url_scrape.dashboard.index');
    });


    Route::get('dashboard', 'DashboardController@index')
        ->name('topicmine.url_scrape.dashboard.index');

    createRoutes([
        [
            'namespace'  => 'topicmine.url_scrape',
            'routeBase'  => 'scrape',
            'controller' => 'UrlScrapeController',
        ]
    ]);

    createRoutes([
        [
            'namespace'  => 'topicmine.url_scrape',
            'routeBase'  => 'url',
            'controller' => 'UrlController',
        ]
    ]);

    Route::get('action', 'UrlController@action')
        ->name('topicmine.url_scrape.url.action');

    Route::get('url/{id}/url-results', 'UrlController@urlResults')
        ->name('topicmine.url_scrape.url.urlResults');
//    Route::get('url/{id}/js_results', 'UrlController@jsResults')->name('admin.data.url.url.js_results');

    Route::get('url/{id}/scrape', 'UrlController@scrape')
        ->name('topicmine.url_scrape.url.scrape');
    Route::post('url/{id}/js-scrape', 'UrlController@jsScrape')
        ->name('topicmine.url_scrape.url.jsScrape');

});