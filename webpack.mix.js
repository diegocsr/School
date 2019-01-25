const mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
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

mix.setPublicPath('public');
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.sass', 'public/css')
   .sass('resources/sass/backend.sass', 'public/css')
   .options({
      processCssUrls: false,
      postCss: [tailwindcss('resources/js/tailwind.js')],
   })
   .copy('resources/image/asset', 'storage/app/public/image')
   .copy('resources/image/galleries', 'public/uploads/galleries')
   .copy('resources/image/teachers', 'public/uploads/teachers')
   .copy('resources/image/events', 'public/uploads/events')
   .copy('resources/image/achievements', 'public/uploads/achievements')
   // .copy('node_modules/line-awesome/css/line-awesome.min.css', 'public/css')
   // .copy('node_modules/line-awesome/fonts', 'public/fonts')

if (mix.inProduction()) {
   mix.version()
}
