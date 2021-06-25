const mix = require("laravel-mix");
const path = require("path");

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
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig(
        {
            resolve:{
                alias: {
                    "@": path.join(__dirname, "/resources/js"),
                    "@api": path.join(__dirname, "/resources/js/api"),
                    "@components": path.join(__dirname, "/resources/js/components"),
                    "@views": path.join(__dirname, "/resources/js/views")
                }
            }
        }
    )
