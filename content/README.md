# Content Package

This package provides content for the Topic Mine website and includes a package that links into 
a WordPress installation if the connection is setup.

It provides the website home page as well as the admin area home page. It also provides dashboards 
for each of the main sections in the admin area of Topic Mine.

## Installation

Add the service provider anywhere after the CoreServiceProvider in the config/app.php file

    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\Content\ContentServiceProvider::class,

To install publish the container bindings, views and routes by running the command:

    php artisan vendor:publish --force
    
## Wordpress

The Wordpress feature requires you to install this package in composer.json:
    
    "jgrossi/corcel": "^1.1",

Then sure you run:

    composer update
    
## Environemnt settings

Add WordPress database connection settings to .env. For developing locally I have:

    DB_HOST_WP=192.168.56.1
    DB_PORT_WP=3306
    DB_DATABASE_WP=wordpress
    DB_USERNAME_WP=topicmine
    DB_PASSWORD_WP=secret