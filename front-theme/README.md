# Topic Mine Front Theme Package

This package contains the assets for the front theme.

## Installation

Make sure Node.js is installed and bootstrap_sass and gulp are installed. 
For example if you're using Laravel Homestead box with Laravel Elixir, package.json 
DevDependencies should include:

    "devDependencies": {
        "font-awesome": "^4.6.3",
        "bootstrap-sass": "^3.3.7",
        "gulp": "^3.9.1",
        "laravel-elixir": "^6.0.0-11",
        "laravel-elixir-webpack-official": "^1.0.2"
    },
  
Then install the packages by running:

    npm install
     
To install this package add the service provider anywhere after the core package provider in 
config.app.php.

    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\FrontTheme\FrontThemeServiceProvider::class,
        

To install publish the assets, views and routes by running the command:

    php artisan vendor:publish --force
    
This will setup the theme's commands in 'gulpfile.js'. Then you will need to run gulp to generate the 
css and JavaScript and to copy the assets to the public directory.

    gulp
    
## Views directory structure

The view will be stored in the resources/views/front directory. The directories are:
- layouts: the master layout files and it's included partials
- statics: these are view templates specific to a controller or package
