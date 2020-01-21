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

mix.copyDirectory('resources/js/admin', 'public/js/admin')
   .copyDirectory('resources/js/vendor', 'public/js/vendor')
   .copyDirectory('resources/js/web', 'public/js/web')
   .copyDirectory('resources/images', 'public/images')
   .copyDirectory('resources/css', 'public/css')
   .copyDirectory('resources/css/web', 'public/css/web');

mix.js('resources/js/app.js', 'public/js/app.js')
   .js('resources/js/admin.js', 'public/js/admin.js')
   .js('resources/js/web/initial.js', 'public/js/web/initial.js')
   .js('resources/js/web/record.js', 'public/js/web/record.js')
   .sass('resources/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}
