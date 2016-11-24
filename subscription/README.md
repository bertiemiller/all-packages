# Topic Mine Subscription Package

This package sets up the subscription process that let's users subscribe to a plan and access
the admin area of the site. Note all the authorisation and account database creation and settings
is handled by the core package, this package only handles the subscription, payment and cancellation.

## Installation

Make sure the following pacakges are in composer.json:

        "laravel/cashier": "~7.0",
        "cartalyst/stripe-laravel": "5.0.*"

Then run:

    composer update
    
To install this package add the service provider anywhere after the core package provider in 
config.app.php.

    Topicmine\Core\CoreServiceProvider::class,
    Topicmine\Subscription\SubscriptionServiceProvider::class,
        
To install publish the config, assets, views database migrations and routes run the command:

    php artisan vendor:publish --force
        
To run the database migrations run:

    php artisan migrate
       
## Environment Settings

Each new subscription will create a new account database which uses this connection by default.
Make sure you add the following to .env and edit where appropriate:

    DB_HOST_ACCOUNT_DATABASE=192.168.10.10
    DB_PORT_ACCOUNT_DATABASE=3306
    DB_DATABASE_ACCOUNT_DATABASE=topicmine_accounts
    DB_USERNAME_ACCOUNT_DATABASE=homestead
    DB_PASSWORD_ACCOUNT_DATABASE=secret

### Stripe subscriptions

You will also need to install Stripe connection keys. My testing keys are:

    STRIPE_KEY=pk_test_9iLtYf80lvu9fibM4pal0lcb
    STRIPE_SECRET=sk_test_wP3qvns7kKo4Nd9N1kW0kjkr
          
       
# Middleware

This command will also update the app/Http/Kernel.php file with 'admin' middleware that, when 
applied to controllers and/or routes, checks account subscriptions for appropriate admin access.
