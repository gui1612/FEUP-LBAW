const mix = require('laravel-mix');
const LiveReloadPlugin = require('webpack-livereload-plugin');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .copyDirectory('resources/assets/images', 'public/images')
    .sass('resources/assets/sass/app.scss', 'public/css', undefined, [
        require('tailwindcss'),
        require('autoprefixer')
    ]);

mix.webpackConfig({
    plugins: [new LiveReloadPlugin({
        useSourceHash: true,
        liveCSS: false
    })]
});