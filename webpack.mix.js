const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
	
mix.sass('resources/sass/app.scss', 'public/css');

mix.copy('node_modules/popper.js/dist/popper.js.map', 'public/js/popper.js.map');

mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts/*', 'public/fonts');