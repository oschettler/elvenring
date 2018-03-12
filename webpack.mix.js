let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/lbd.js', 'public/js')
    .copy('resources/assets/css/*', 'public/css/')
    .sass('resources/assets/sass/lbd.scss', 'public/css')
    .copy('resources/assets/fonts/*', 'public/fonts/')
    .copy('resources/assets/img/*', 'public/img/');
