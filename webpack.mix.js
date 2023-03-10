let mix  = require('laravel-mix');

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


var vendors = 'node_modules/';

var resourcesAssets = 'resources/assets/';
var srcCss = resourcesAssets + 'css/';
var srcJs = resourcesAssets + 'js/';

var dest = 'public/';
var destFonts = dest + 'fonts/';
var destCss = dest + 'css/';
var destJs = dest + 'js/';

var paths = {
    'jquery': vendors + 'jquery/dist/',
    'jqueryUi': vendors + 'components-jqueryui/',
    'moment': vendors + 'moment/',
    'bootstrap': vendors + 'bootstrap/',
    'dataTables': vendors + 'datatables/media/',
    'datatables_bs': vendors + 'datatables.net-bs/',
    'fontawesome': vendors + 'font-awesome/',
    'animate': vendors + 'animate.css/',
    'underscore': vendors + 'underscore/',
    'tether': vendors + 'tether/dist/',
    'jQueryStorageAPI': vendors + 'jquery-storage-api',
    'pace': vendors + 'pace-progress/',
    'lazyload': vendors + 'lazyload',
    'screenfull': vendors + 'screenfull/dist/',
    'select2': vendors + 'select2/dist/',
    'fullcalendar': vendors + 'fullcalendar/dist/',
    'summernote': vendors + 'summernote/dist/',
    'morris': vendors + 'morris.js/',
    'raphael': vendors + 'raphael/',
    'pusherJs': vendors + 'pusher-js/',
    'icheck': vendors + 'icheck/',
    'jasnyBootstrap': vendors + 'jasny-bootstrap/dist/',
    'toastr': vendors + 'toastr/build/',
    'dropzone': vendors + 'dropzone/dist/',
    'bootstrapValidator': vendors + 'bootstrapvalidator/dist/',
    'select2BootstrapTheme': vendors + 'select2-bootstrap-theme/dist/',
    'c3': vendors + '/c3/',
    'd3': vendors + '/d3/',
    'slimscroll': vendors + 'jquery-slimscroll/',
    'bootstrap_tagsinput': vendors + 'bootstrap-tagsinput/dist/',
    'lobibox': vendors + 'lobibox/dist/',
    'flatpickr': vendors + 'flatpickr/dist/',
    'jvectormap':vendors+'jvectormap/',
    'countup':vendors+'countup.js/dist/',
    'datatablesnet_buttons': vendors + 'datatables.net-buttons/',
    'datatablesnet_buttons_bs': vendors + 'datatables.net-buttons-bs/',
    'pdfmake' : vendors + 'pdfmake/',
    'jszip' : vendors + 'jszip/',
    'dragula' : vendors + 'dragula/',
};

//Custom Styles
mix.combine(
    [
        srcCss + 'lcrm_bootstrap.css',
        // srcCss + 'metisMenu.min.css',
        srcCss + 'lcrm.css',
        srcCss + 'mail.css'
    ], destCss + 'secure.css');

//Custom Javascript
mix.js(srcJs + 'app.js', destJs + 'secure.js');
mix.copy(srcJs + 'stripe', destJs + 'stripe');
mix.copy(srcCss + 'stripe', destCss + 'stripe');

mix.copy(srcCss + 'tasks.css', destCss + 'tasks.css');

mix.copy(paths.bootstrap + 'dist/css/bootstrap.min.css', 'public/css');


mix.copy('resources/assets/js/metisMenu.min.js', 'public/js');
mix.copy('resources/assets/js/lcrm_app.js', 'public/js');
mix.copy('resources/assets/js/todolist.js', 'public/js');

//lobibox
mix.copy(paths.lobibox + 'css/lobibox.min.css', 'public/css');
mix.copy(paths.lobibox + 'js/lobibox.min.js', 'public/js');
mix.copy(paths.lobibox + 'sounds', 'public/sounds');

// Copy fonts straight to public
mix.copy(paths.bootstrap + 'fonts', destFonts);
mix.copy(paths.bootstrap + 'fonts', destFonts+'bootstrap/');
mix.copy(paths.fontawesome + 'fonts', destFonts);
mix.copy('resources/assets/css/material-design-icons/iconfont', destFonts);

mix.copy('resources/assets/img', 'public/img',false);
mix.copy('resources/assets/images', 'public/images',false);
mix.copy('resources/assets/img/logo.png', 'public/uploads/site');
mix.copy('resources/assets/img/street.jpg', 'public/img');
mix.copy('resources/assets/img/fav.ico', 'public/uploads/site');
mix.copy('resources/assets/img/user.png', 'public/uploads/avatar');

// copy js files ( we don't need to combine all files into single js)
// mix.copy(paths.screenfull + 'screenfull.min.js', 'public/js');

//c3&d3 chart css and js files
mix.copy(paths.c3 + 'c3.min.css', 'public/css');
mix.copy(paths.c3 + 'c3.min.js', 'public/js');
mix.copy(paths.d3 + 'd3.min.js', 'public/js');
mix.copy('resources/assets/js/d3.v3.min.js', 'public/js');

//jvector map files
mix.copy(paths.jvectormap + 'jquery-jvectormap.min.js', 'public/js');
mix.copy(paths.jvectormap + 'jquery-jvectormap.css', 'public/css');
mix.copy(paths.jvectormap + 'tests/assets/jquery-jvectormap-world-mill-en.js', 'public/js');
mix.copy(paths.jvectormap + 'tests/assets/jquery-jvectormap-us-aea-en.js', 'public/js');

// install
mix.copy('resources/assets/css/custom_install.css', 'public/css');

//icheck
mix.copy(paths.icheck + 'skins/', 'public/css');
mix.copy(paths.icheck + 'icheck.min.js', 'public/js');

//countUp
mix.copy(paths.countup + 'countUp.min.js', 'public/js');
mix.copy('resources/assets/css/login_register.css', 'public/css');

//slimscroll
mix.copy(paths.slimscroll + 'jquery.slimscroll.js', 'public/js');

//bootstrap_tagsinput
mix.copy(paths.bootstrap_tagsinput + 'bootstrap-tagsinput.css', 'public/css');
mix.copy(paths.bootstrap_tagsinput + 'bootstrap-tagsinput.js', 'public/js');

// datatables
mix.copy(paths.datatablesnet_buttons + 'js/buttons.colVis.min.js', destJs + 'datatables/buttons')
mix.copy(paths.datatablesnet_buttons + 'js/buttons.flash.min.js', destJs + 'datatables/buttons')
mix.copy(paths.datatablesnet_buttons + 'js/buttons.html5.min.js', destJs + 'datatables/buttons')
mix.copy(paths.datatablesnet_buttons + 'js/buttons.print.min.js', destJs + 'datatables/buttons')
mix.copy(paths.datatablesnet_buttons + 'js/dataTables.buttons.min.js', destJs + 'datatables/buttons')

mix.copy(paths.datatablesnet_buttons_bs + 'css/buttons.bootstrap.min.css', destCss + 'datatables/buttons');
mix.copy(paths.datatablesnet_buttons_bs + 'js/buttons.bootstrap.min.js', destJs + 'datatables/buttons');

// pdfmake
mix.copy(paths.pdfmake + 'build/pdfmake.min.js', destJs + 'pdfmake')
mix.copy(paths.pdfmake + 'build/vfs_fonts.js', destJs + 'pdfmake')

// jszip
mix.copy(paths.jszip + 'dist/jszip.min.js', destJs + 'jszip')

// dragula
mix.copy(paths.dragula + 'dist/dragula.min.css', destCss + 'dragula')
mix.copy(paths.dragula + 'dist/dragula.min.js', destJs + 'dragula')

// jquery-ui
mix.copy(srcJs + 'jquery-ui', destJs + 'jquery-ui')

//CSS Libraries
mix.combine(
    [
        paths.fontawesome + "css/font-awesome.min.css",
        paths.animate + "animate.min.css",
        srcCss + "material-design-icons/material-design-icons.css",
        paths.select2 + "css/select2.min.css",
        paths.datatables_bs + 'css/dataTables.bootstrap.css',
        paths.fullcalendar + 'fullcalendar.css',
        paths.summernote + 'summernote.css',
        paths.summernote + 'summernote-bs3.css',
        paths.morris + 'morris.css',
        paths.bootstrapValidator + 'css/bootstrapValidator.min.css',
        paths.dropzone + 'dropzone.css',
        paths.jasnyBootstrap + "css/jasny-bootstrap.min.css",
        paths.toastr + 'toastr.min.css',
        paths.select2BootstrapTheme + "select2-bootstrap.min.css",
        paths.flatpickr + "flatpickr.min.css"
    ], destCss + 'libs.css')
    .version();


//JS Libraries
mix.combine(
    [
        paths.jquery + "jquery.min.js",
        paths.jqueryUi + "jquery-ui.min.js",
        paths.tether + "js/tether.min.js",
        paths.bootstrap + "dist/js/bootstrap.min.js",
        paths.dataTables + "js/jquery.dataTables.min.js",
        paths.datatables_bs + "js/dataTables.bootstrap.js",
        paths.pace + 'pace.min.js',
        paths.underscore + "underscore-min.js",
        paths.select2 + "js/select2.min.js",
        paths.moment + 'moment.js',
        paths.fullcalendar + 'fullcalendar.js',
        paths.summernote + 'summernote.js',
        paths.morris + 'morris.js',
        paths.raphael + 'raphael.js',
        paths.pusherJs + 'dist/web/pusher.min.js',
        paths.toastr + 'toastr.min.js',
        paths.bootstrapValidator + 'js/bootstrapValidator.min.js',
        paths.jasnyBootstrap + "js/jasny-bootstrap.min.js",
        srcJs + "palette.js"
    ], destJs + 'libs.js')
    .version();

// datatables mix js
mix.scripts([
    paths.datatablesnet_buttons + 'js/dataTables.buttons.min.js',
    paths.datatablesnet_buttons_bs + 'js/buttons.bootstrap.min.js',
    paths.datatablesnet_buttons + 'js/buttons.html5.min.js',
    paths.datatablesnet_buttons + 'js/buttons.print.min.js',
    paths.jszip + 'dist/jszip.min.js',
    paths.pdfmake + 'build/pdfmake.min.js',
    paths.pdfmake + 'build/vfs_fonts.js'
],destJs + 'datatables_app.js').version();
