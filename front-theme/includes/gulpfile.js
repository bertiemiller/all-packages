
const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir(mix => {

    // Front Copy
    mix

        .copy(
            'node_modules/font-awesome/fonts',
            'public/front-theme/fonts/font-awesome'
        )
        .copy(
            'node_modules/bootstrap-sass/assets/fonts/bootstrap',
            'public/front-theme/fonts/bootstrap'
        )
        .copy(
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
            'public/front-theme/js/vendor/bootstrap'
        )
        .copy(
            'resources/assets/css/front-theme/vendor/google/google-font-css.css',
            'public/front-theme/css/vendor/google/fonts.css'
        )
        .copy(
            'resources/assets/images/front-theme',
            'public/front-theme/images'
        )
        .copy(
            'resources/assets/js/front-theme/vendor/jquery',
            'public/front-theme/js/vendor/jquery'
        )


    // Front
    mix

    .sass([
        'front-theme/app.scss'
    ], 'resources/assets/css/front-theme/app.css')

    .styles([
        'front-theme/app.css'
    ], 'public/front-theme/css/front.css')

    .scripts([
        'front-theme/app.js'
    ], 'public/front-theme/js/front.js')

});
