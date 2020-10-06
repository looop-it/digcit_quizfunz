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

mix.js('resources/assets/js/app.js', 'public/js')
   .extract([
      'swiper',
      'jquery',
      'moment',
      'lodash',
      'vue',
      'select2',
      'sweetalert2'
   ])
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('public/home/scss/common.scss', 'public/home/css/common.css')
   .sass('public/home/scss/hot.scss', 'public/home/css/hot.css')
   .sass('public/home/scss/other.scss', 'public/home/css/other.css')
   .sass('public/home/scss/style.scss', 'public/home/css/style.css')
   // .sass('public/home/scss/ranking.scss', 'public/home/css/ranking.css')
   .sourceMaps();


mix.browserSync('quizfunz.app')
   .disableSuccessNotifications();
