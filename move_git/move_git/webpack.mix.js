const mix = require('laravel-mix');

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

mix.js('resources/js/vuejs/project.js', 'public/js/vuejs')
    .js('resources/js/vuejs/projectdetail.js', 'public/js/vuejs')
    .js('resources/js/vuejs/home.js', 'public/js/vuejs');
