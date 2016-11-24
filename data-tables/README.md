# Topic Mine Data Tables Package

## Installation
 
To install this package add the service provider anywhere after the core package provider in 
config.app.php.

        Topicmine\Core\CoreServiceProvider::class,
        Topicmine\DataTables\DataTablesServiceProvider::class,

Note all the API features of this package are installed in the core package. 

Make sure Node.js is installed and then make sure the following packages are in the 
package.json file: 
    
    "devDependencies": {
        "gulp": "^3.9.1",
        "laravel-elixir": "^6.0.0-11",
        "laravel-elixir-vue-2": "^0.2.0",
        "laravel-elixir-webpack-official": "^1.0.2",
        "lodash": "^4.16.2",
        "vue": "^2.0.1",
        "vue-resource": "^1.0.3"
    },

Note this package requires Vue JS Version 2.

Then run:

    npm install

To publish the config, routes, assets and views run

    php artisan vendor:publish --force

## Environment settings

This packages uses the 'CORE_API_DOMAIN' environment setting in the .env file 
which is published by the core pacakge. Make sure this domain is setup on the 
server and points to the public folder of this site.

## Routes

All the Api routes for datatables are installed in this package using the CORE_API_DOMAIN
domain.

## Semantic UI

The package requires Semantic UI. This is included in the view files as a script link:

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.css"
              media="screen" title="no title" charset="utf-8">
              
Alternatively this could be installed with in Node.js by running:

    npm install semantic-ui --save
    
(However I have failed to do this on the Laravel Homestead box on my Windows PC)

## A note on CSS

The Semantic UI include script distorts the css for the admin-theme pacakge. 
This needs to be addressed.
