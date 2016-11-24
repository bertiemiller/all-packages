# Admin Theme Package

This package contains the assets for the admin theme.

## Installation

Firstly make sure Node.js is installed and bootstrap_sass and gulp are installed. 
For example if you're using Laravel Homestead box with Laravel Elixir, package.json 
devDependencies should include:

    "devDependencies": {
        "font-awesome": "^4.6.3",
        "bootstrap-sass": "^3.3.7",
        "gulp": "^3.9.1",
        "laravel-elixir": "^6.0.0-11",
        "laravel-elixir-webpack-official": "^1.0.2"
    },
  
Then install the packages by running:

    npm install

Add the service provider anywhere after the CoreServiceProvider in the config/app.php file:

    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\AdminTheme\AdminThemeServiceProvider::class,

To install publish the container bindings, assets, views and routes by running the command:

    php artisan vendor:publish --force
    
This will setup the theme's commands in 'gulpfile.js'. Then you will need to run gulp to generate the 
css and JavaScript and to copy the assets to the public directory:

    gulp
    
## Views directory structure

The view will be stored in the resources/views/admin directory. The directories are:
- layouts: the master layout files and it's included partials
- panels: these are generic view template files called directory from various package controllers
- statics: these are view templates specific to a controller or package
