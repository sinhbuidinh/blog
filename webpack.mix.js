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

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/jquery-1.11.3.min.js', 'public/js')
   .js('resources/js/base/jquery-3.2.1.min.js', 'public/js')
   .js('resources/js/base/jquery-migrate-3.0.0.js', 'public/js')
   .js('resources/js/base/bootstrap.min.js', 'public/js')
   .js('resources/js/bootstrap-datepicker.min.js', 'public/js')
   .copy('resources/js/moment.min.js', 'public/js/moment.min.js')
   .copy('resources/js/daterangepicker.min.js', 'public/js/daterangepicker.min.js')
   .js('resources/js/base/owl.carousel.min.js', 'public/js')
   .js('resources/js/base/jquery.waypoints.min.js', 'public/js')
   .js('resources/js/base/jquery.stellar.min.js', 'public/js')
   .js('resources/js/base/main.js', 'public/js')
   .js('resources/js/admin/address.js', 'public/js')
   .js('resources/js/admin/general.js', 'public/js')
   .js('resources/js/admin/parcel.js', 'public/js/admin')
   .js('resources/js/admin/package.js', 'public/js/admin')
   .js('resources/js/admin/forward.js', 'public/js/admin')
   .js('resources/js/user/index.js', 'public/js/user')
   .js('resources/js/user/guest-slider.js', 'public/js/user')
   .copy("resources/images/", "public/images/")
   .sass('resources/sass/admin/index.scss', 'public/css/admin')
   .sass('resources/sass/fonts_api_josefin-sans-300-400-700.scss', 'public/css')
   .sass('resources/sass/base/style.scss', 'public/css')
   .sass('resources/sass/base/bootstrap.scss', 'public/css')
   .copy('resources/sass/base/bootstrap-datepicker3.min.css', 'public/css')
   .copy('resources/sass/base/daterangepicker.css', 'public/css')
   .sass('resources/sass/base/animate.scss', 'public/css')
   .sass('resources/sass/base/owl.carousel.min.scss', 'public/css')
   .sass('resources/fonts/ionicons/css/ionicons.min.scss', 'public/fonts/ionicons')
   .sass('resources/fonts/fontawesome/css/font-awesome.min.scss', 'public/fonts/fontawesome')
   .sass('resources/fonts/flaticon/font/flaticon.scss', 'public/fonts/flaticon')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('resources/sass/select2.min.css', 'public/css/select2.min.css')
   .copy('resources/price/', 'public/price/')
   .sass('resources/sass/kn247/search.scss', 'public/css/kn247')
   .sass('resources/sass/kn247/index.scss', 'public/css/kn247')
   .sass('resources/sass/kn247/guest-slider.scss', 'public/css/kn247')
   .sass('resources/sass/kn247/style.scss', 'public/css/kn247');
