# Topicmine Core Package

This package sets up the Topic Mine website and is required by all Topic Mine packages. 

It installs a collection of third party packages which are core to the running of the site. 

The package is activated when a controller extends the CoreController and calls __construct(). 
This activates core setting the controller action, the route base, the controller's repository 
and the repository's model. These settings can then be used throughout the site.

## Models

### $relationships

Each model can define relationships. This makes use of Eloquent's feature of chaining related 
models. These relationships can be set replacing the model in the repository - the repository methods
continue to work as normal. 

For example, without relationships finding the first user is:

    $user = App\User::first();

With the following relationship defined in the App\Accounts model:

    public function users()
    {
        return $this->hasMany('App\User');
    }
 
Finding the first account user is:

    $accountUser = App\Account::find(1)->users()->first()
    
        
### $updateFields
    
This variable defines the fields that are presented in views for edit and create REST methods.


## Core Packages

A brief outline of the packages is as follows.


### prettus/l5-repository

The CoreRepository extends this package. Repository interfaces are bound in controllers and are 
used to extract model data. The CoreRepository handles all the method calls from controllers. 

Each repository has one model. This model can be overriden by model relationships explained above.

Each repository can also state a transformer which modifies the data sent to the presentation layer. 

The repository also has criteria and scopes which affect the query made, including queries from Api 
calls.

#### $searchableFields

In this package searchable fields defines which fields can be searched through Api calls.


### dingo/api and dingo/blueprint

This sets up the Api routes and handles AJAX requests. 


### tymon/jwt-auth

This handles the authorisation for AJAX requests using tokens.


### barryvdh/laravel-cors

This makes sure cross domain requests are handled using 'cors' middleware.


### Other standard core packages

- league/fractal - Repository Transformers depend on this
- laracasts/utilities - binds backend variables to JavaScript which is used in VueJs
- laravelcollective/html - for generating forms
- doctrine/dbal - a database abstraction layer
- hieu-le/active - for applying css classes to active menu items using matching
- laracasts/flash - for responding with messages using sessions 
- robclancy/presenter - a dependency of prettus/l5-repository although it is not used to date


## Installation instructions

### composer.json

Make sure you have a clean installation of Laravel framework. 

Either clone each package individually from Gitlab to install or clone the all-packages repository which 
has the latest version of all the packages:
 
     git clone git@gitlab.com:topicmine/all-packages.git

Note this is just for ease of installation as installing them separately has been very tricky and slow
on my computer (Windows).  I'd still like the packages to be kept separate.

Your composer.json should then be as follows:

    {
        "name": "laravel/laravel",
        "description": "The Laravel Framework.",
        "keywords": ["framework", "laravel"],
        "license": "MIT",
        "type": "project",
        "require": {
            "php": ">=5.6.4",
            "laravel/framework": "5.3.*"
        },
        "minimum-stability": "dev",
        "prefer-stable": true,
        "require-dev": {
            "fzaninotto/faker": "~1.4",
            "mockery/mockery": "0.9.*",
            "phpunit/phpunit": "~5.0",
            "symfony/css-selector": "3.1.*",
            "symfony/dom-crawler": "3.1.*",
    
            "prettus/l5-repository": "^2.6",
            "league/fractal": "^0.13.0",
            "robclancy/presenter": "1.3.*",
            "laracasts/utilities": "~2.0",
            "laravelcollective/html": "5.3.*",
            "doctrine/dbal": "^2.5",
            "hieu-le/active": "~2.0",
            "laracasts/flash": "^2.0",
            "jgrossi/corcel": "^1.1",
            "laravel/cashier": "~7.0",
            "tymon/jwt-auth": "0.5.*",
            "cartalyst/stripe-laravel": "5.0.*",
            "dingo/api": "1.0.*@dev",
            "dingo/blueprint": "0.1.*",
            "barryvdh/laravel-cors": "^0.8",
            "fabpot/goutte": "^3.1"
        },
        "autoload": {
            "classmap": [
                "database"
            ],
            "psr-4": {
                "App\\": "app/",
                "Topicmine\\Core\\": "all-packages/core/src/",
                "Topicmine\\Subscription\\": "all-packages/subscription/src/",
                "Topicmine\\AdminTheme\\": "all-packages/admin-theme/src/",
                "Topicmine\\UserProfile\\": "all-packages/user-profile/src/",
                "Topicmine\\UserAccess\\": "all-packages/user-access/src/",
                "Topicmine\\Content\\": "all-packages/content/src",
                "Topicmine\\FrontTheme\\": "all-packages/front-theme/src/",
                "Topicmine\\UrlScrape\\": "all-packages/url-scrape/src/",
                "Topicmine\\DataTables\\": "all-packages/data-tables/src/"
            },
            "files": [
                "all-packages/core/src/helpers.php"
            ]
        },
        "autoload-dev": {
            "classmap": [
                "tests/TestCase.php"
            ]
        },
        "scripts": {
            "post-root-package-install": [
                "php -r \"file_exists('.env') || copy('.env.example', '.env');\""
            ],
            "post-create-project-cmd": [
                "php artisan key:generate"
            ],
            "post-install-cmd": [
                "Illuminate\\Foundation\\ComposerScripts::postInstall",
                "php artisan optimize",
                "php artisan vendor:publish --force"
            ],
            "post-update-cmd": [
                "Illuminate\\Foundation\\ComposerScripts::postUpdate",
                "php artisan optimize",
                "php artisan vendor:publish --force"
            ]
        },
        "config": {
            "preferred-install": "dist"
        }
    }

(A side note - please advise on an easier way to install as this takes a lot of time).

Then to install everything run:
        
    composer update

    
### Install the service providers
    
Add the core package provider in config.app.php above every other Topic Mine package:

    Topicmine\Core\CoreServiceProvider::class,
    // Other packages here...

CoreServiceProvider will register all the dependent package service providers as well.

For a full site installation add:

    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\Subscription\SubscriptionServiceProvider::class,
    Topicmine\AdminTheme\AdminThemeServiceProvider::class,
    Topicmine\UserAccess\UserAccessServiceProvider::class,
    Topicmine\UserProfile\UserProfileServiceProvider::class,
    Topicmine\Content\ContentServiceProvider::class,
    Topicmine\FrontTheme\FrontThemeServiceProvider::class,
    Topicmine\DataTables\DataTablesServiceProvider::class,
    Topicmine\UrlScrape\UrlScrapeServiceProvider::class,
    
For a development site installation add the CoreServiceProvider and the relevant service providers.
    For example for development of the UrlScrape package you could add:
    
    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\UrlScrape\UrlScrapeServiceProvider::class,  
    
Note the CoreServiceProvider must always be at the top.

For more information about developing packages see the information further down.


### Publishing package files

To publish the container bindings, views, assets, config, routes for the core and all 
the dependent packages run:

    php artisan vendor:publish --force
    
On first installation you should run this command twice. The first time publishes third party files.
It is only when you write it again that some of the configuration can happen on these files. It 
cannot damage the system/configuration in any way - you can run it as frequently as you like.
    
   
### Install the environemnt settings in the .env file

Update the APP_URL setting:

    APP_URL=http://topicmine.loc

Then install the other environment settings explained in the environment settings section:

    DB_CONNECTION=mysql
    DB_HOST=192.168.10.10
    DB_PORT=3306
    DB_DATABASE=mysql
    DB_USERNAME=homestead
    DB_PASSWORD=secret

    DB_HOST_ACCOUNT_DATABASE=192.168.10.10
    DB_PORT_ACCOUNT_DATABASE=3306
    DB_DATABASE_ACCOUNT_DATABASE=topicmine
    DB_USERNAME_ACCOUNT_DATABASE=homestead
    DB_PASSWORD_ACCOUNT_DATABASE=secret

    API_STANDARDS_TREE=x
    API_PREFIX=api
    API_VERSION=v1
    API_CONDITIONAL_REQUEST=false
    API_STRICT=false
    API_DEBUG=true
    JWT_BLACKLIST_GRACE_PERIOD = 2
    
    # you'll need to setup an installation ow WP, but it should work by default without
    # if these settings are there
    DB_HOST_WP=192.168.56.1
    DB_PORT_WP=3306
    DB_DATABASE_WP=wordpress_database
    DB_USERNAME_WP=homestead
    DB_PASSWORD_WP=secret

    MAIL_DRIVER=smtp
    MAIL_HOST=mail.hover.com
    Mail_PORT=587
    MAIL_USERNAME=info@topicmine.io
    MAIL_PASSWORD=t0p1cm1n38888
    MAIL_ENCRYPTION=tls
        
    STRIPE_KEY=pk_test_9iLtYf80lvu9fibM4pal0lcb
    STRIPE_SECRET=sk_test_wP3qvns7kKo4Nd9N1kW0kjkr
   
    CORE_API_DOMAIN=api.master.loc
    ACCOUNT_API_DOMAIN=api.master.loc
    SOURCES_API_DOMAIN=api.master.loc
    
Note to adjust any settings according (particularly database settings) to your local setup.
   
### Running database migrations and seeds

Firstly clear the autoload for all the newly installed packages by running:

    composer dump-autoload
            
Then run to install the databases and run the imports:

    php artisan migrate --seed


## package.json installation

You will also need to make sure Laravel Elixir is installed. Follow the instructions here:

    https://laravel.com/docs/5.3/elixir#installation

The update your package.json file as follows:

    {
      "private": true,
      "scripts": {
        "prod": "gulp --production",
        "dev": "gulp watch"
      },
      "devDependencies": {
        "font-awesome": "^4.6.3",
        "bootstrap-sass": "^3.3.7",
        "gulp": "^3.9.1",
        "jquery": "^3.1.0",
        "laravel-elixir": "^6.0.0-11",
        "laravel-elixir-vue-2": "^0.2.0",
        "laravel-elixir-webpack-official": "^1.0.2",
        "lodash": "^4.16.2",
        "vue": "^2.0.1",
        "vue-resource": "^1.0.3"
      },
      "dependencies": {
        "npm-check": "^5.4.0",
        "vuetable-2": "^0.9.2"
      }
    }

Note the vuetable-2 package is added for the Topic Mine DataTables package.

You then need to run:

    npm install

Or on Windows

    npm install --no-bin-links
    
Finally run gulp to copy assets over to the public folder and to generate the css and js files.

    gulp
    

### Notes on debugging

I have had some issues when running gulp with bootstrap-sass so have had to rebuild the package by 
running the following command after installation:

    npm rebuild bootstrap-sass

Also sometimes I need to install node-sass to remove errors:

    npm install node-sass

Then run gulp again:

    gulp


## Environment settings

The following should be added to the .env file.


### Mysql

The default mysql database for accounts and users needs to be connected. 
Development locally using Laravel Homestead I have used the following settings:

    DB_HOST_ACCOUNT_DATABASE=192.168.10.10
    DB_PORT_ACCOUNT_DATABASE=3306
    DB_DATABASE_ACCOUNT_DATABASE=topicmine_core
    DB_USERNAME_ACCOUNT_DATABASE=topicmine
    DB_PASSWORD_ACCOUNT_DATABASE=secret

### WordPress database connection

If you are installing a package that requires a WordPress connection (e.g. Topicmine\Content) 
then you need to add the WordPress database connection settings to .env. For developing locally 
I have:

    DB_HOST_WP=192.168.56.1
    DB_PORT_WP=3306
    DB_DATABASE_WP=topicmine_wordpress
    DB_USERNAME_WP=homestead
    DB_PASSWORD_WP=secret

### Accounts database connection

Each new subscription will create a new account database which uses this connection by default.
IF you are installing the subscription packages are anything dependent on an account database
make sure you add the following to .env and edit where appropriate:

    DB_HOST_ACCOUNT_DATABASE=192.168.10.10
    DB_PORT_ACCOUNT_DATABASE=3306
    DB_DATABASE_ACCOUNT_DATABASE=topicmine_accounts
    DB_USERNAME_ACCOUNT_DATABASE=homestead
    DB_PASSWORD_ACCOUNT_DATABASE=secret
       
       
#### Stripe subscriptions

You will also need to install Stripe connection keys. My testing keys are:

    STRIPE_KEY=pk_test_9iLtYf80lvu9fibM4pal0lcb
    STRIPE_SECRET=sk_test_wP3qvns7kKo4Nd9N1kW0kjkr
       
       
### Api Domains

Computations are spread across different servers to enable flexibility and scalability. These
different servers will have different connections which are specified by adding these
to .env:

    CORE_API_DOMAIN=api.master.loc
    ACCOUNT_API_DOMAIN=api.master.loc
    SOURCES_API_DOMAIN=api.master.loc

The CORE_API_DOMAIN connects to the main account and user management. 
The ACCOUNT_API_DOMAIN is where account settings and reports are stored. 
The SOURCES_API_DOMAIN is where a central repository of data will be stored 
(not yet developed). 


For local servers adjust the domains as appropriate.


### Mail

info@topicmine.io is the default address for testing at the moment.

    MAIL_DRIVER=smtp
    MAIL_HOST=mail.hover.com
    Mail_PORT=587
    MAIL_USERNAME=info@topicmine.io
    MAIL_PASSWORD=t0p1cm1n38888
    MAIL_ENCRYPTION=tls


### Dingo Api Settings

    API_STANDARDS_TREE=x
    API_PREFIX=api
    API_VERSION=v1
    API_CONDITIONAL_REQUEST=false
    API_STRICT=false
    API_DEBUG=true
    JWT_BLACKLIST_GRACE_PERIOD = 2
    
You can add the API_DOMAIN but this makes the auth insist that the domain is this domain.
The setting feeds into conf/api.php which is the Dingo config file. If cors middleware is applied
then this will check if the API_DOMAIN is the same as listings in config/cors.php allowedOrigins.

    API_DOMAIN=api.topicmine.io # if used it must be sepcidifed in config/cors.php allowedOrigins

For local servers adjust the domain as appropriate.

## Package Development

The core package has been designed to allow for easy package development. For example the UrlScrape 
package could be developed with just the core package using static views in the UrlScrape package. 
This can be enabled by extending the UrlController with CoreController instead of DataTablesController.
This will then lead the application to look for static view files.

There is no need to install subscription when developing - user authorisation is handled by the 
default Laravel installation. 

There is no need to install the admin or front themes too. The core has a minimal default master view 
which handles templates and navigation.

It is therefore easy to switch between the full site and package development. To switch to package 
development simply uncomment the other service providers in config/app.php as follows:

            Topicmine\Core\CoreServiceProvider::class,
    //        Topicmine\Subscription\SubscriptionServiceProvider::class,
    //        Topicmine\AdminTheme\AdminThemeServiceProvider::class,
    //        Topicmine\UserAccess\UserAccessServiceProvider::class,
    //        Topicmine\UserProfile\UserProfileServiceProvider::class,
    //        Topicmine\Content\ContentServiceProvider::class,
    //        Topicmine\FrontTheme\FrontThemeServiceProvider::class,
    //        Topicmine\DataTables\DataTablesServiceProvider::class,
            Topicmine\UrlScrape\UrlScrapeServiceProvider::class,

The run:

    php artisan vendor:publish --force
    
Do the reverse to switch back to the main site, running php artisan vendor:publish --force again.

## Admin area login details

Test the installation with the following login details:

Super User:

    email: info:topicmine.io
    pass: admin
    
Account Administrator:
    
    email: admin@topicmine.io
    pass: admin
