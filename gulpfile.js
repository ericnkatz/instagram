var elixir = require('laravel-elixir');

var paths = {
    'lodash': './vendor/bower_components/lodash',
    'jquery': './vendor/bower_components/jquery'
}

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less')
    	.sass('toolkit.scss')
    	.copy(paths.lodash + '/**.js', 'public/js')
    	.copy(paths.jquery + '/dist/**.js', 'public/js');
});
