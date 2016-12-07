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
       .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/fonts/bootstrap')
       .copy('node_modules/pagedown-editor/wmd-buttons.png','public/pagedown/wmd-buttons.png')
       .webpack(['common.js', 'login.js', 'user.js', 'post.js', 'postedit.js'])
       .phpUnit();
});
