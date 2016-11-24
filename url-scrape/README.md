# Topic Mine Url Scrape Package

This package handles Url Scrapes and their respective Urls.

## Installation

To install add the service provider anywhere after the core package provider in config.app.php. 
This package also uses Topicmine's Datatables package so make sure this is included as well. 

    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\DataTables\DataTablesServiceProvider::class,
    Topicmine\UrlScrape\UrlScrapeServiceProvider::class,

Make sure the following is added to composer.json "require-dev":

    "fabpot/goutte": "^3.1"
    
Then run:

    composer update
    
To publish the container bindings, config, routes, assets, scripts, views, 
database migrations and seeds run:

    php artisan vendor:publish --force
    
To run the database migrations run:

    php artisan migrate
    
And to run the seeds run:

    php artisan db:seed
    
Or to do both at once:

    php artian migrate --seed