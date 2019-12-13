let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Custom Mix setup
 |--------------------------------------------------------------------------
 |
 */

mix
    .setPublicPath('../../../public/vendor/survey-manager/')
    .js('resources/assets/js/survey-manager.js', 'js/')
    .js('resources/assets/js/survey-front.js', 'js/');
