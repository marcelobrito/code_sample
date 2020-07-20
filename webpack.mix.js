const mix = require('laravel-mix');
require('laravel-mix-polyfill');
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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
   .polyfill({
      enabled: true,
      useBuiltIns: "usage",
      targets: false
   });

if (process.env.npm_lifecycle_event !== 'hot') {
    mix.version()
    }
    const path = require('path');
    // fix css files 404 issue
    mix.webpackConfig({
    devServer: {
        contentBase: path.resolve(__dirname, 'public'),
    }
    });

mix.webpackConfig({
    devServer: {
        proxy: {
            '*': 'http://localhost:8000'
        }
    }
});
