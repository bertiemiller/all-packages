# Topic Mine User Access Package

This package handles User's access to admin by attaching roles, permission groups and permissions
to their profiles.

## Installation

To install add the service provider anywhere after the core package provider in config.app.php. 
This package also uses Topicmine's Datatables package so make sure this is included as well. 

    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\DataTables\DataTablesServiceProvider::class,
    Topicmine\UserAccess\UserAccessServiceProvider::class,

To publish the container bindings, config, routes run:

    php artisan vendor:publish --force
    