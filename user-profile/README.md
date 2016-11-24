# Topic Mine User Profile Package

This package handles User's personal profile.

## Installation

To install add the service provider anywhere after the core package provider in config.app.php. 
This package also uses Topicmine's Datatables package so make sure this is included as well. 

    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\DataTables\DataTablesServiceProvider::class,
    Topicmine\UserProfile\UserProfileServiceProvider::class,

To publish the container bindings, views, config, routes run:

    php artisan vendor:publish --force
    