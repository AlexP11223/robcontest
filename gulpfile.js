process.env.DISABLE_NOTIFIER = true; // disable desktop notifications (annoying if using watch and without VM)

const elixir = require('laravel-elixir');

const phpunit = require('gulp-phpunit');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application.
 */

elixir((mix) => {
    mix.sass('app.scss')
       .webpack('app.js')
       .webpack('login.js')
       .phpUnit();
});
