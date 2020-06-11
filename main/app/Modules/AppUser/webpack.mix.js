const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv')
	.config({
		path: __dirname + '/../../../.env',
		// debug: true
	}));

// console.log( process.env );

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@user-pages': __dirname + '/Resources/js/Pages',
			'@user-shared': __dirname + '/Resources/js/Shared',
			'@user-assets': __dirname + '/Resources'
		},
	},
})

if (['buildcss'].includes(process.env.npm_config_section)) {
	// mix.copyDirectory(__dirname + '/Resources/img', 'public_html/img');
	// mix.copyDirectory(__dirname + '/Resources/fonts', 'public_html/fonts');

	mix.sass(__dirname + '/Resources/sass/app.scss', 'css/dashboard-app.css')
} else {

	mix.scripts([
        __dirname + '/Resources/js/vendor/jquery-3.2.1.min.js',
        __dirname + '/Resources/js/vendor/jquery.min.js',
        __dirname + '/Resources/js/vendor/popper.min.js',
        __dirname + '/Resources/js/vendor/bootstrap.min.js',
        __dirname + '/Resources/js/vendor/feather.min.js',
        __dirname + '/Resources/js/vendor/jquery.overlayScrollbars.min.js',
        __dirname + '/Resources/js/vendor/yaybar.js',
        __dirname + '/Resources/js/vendor/ofi.min.js',
        __dirname + '/Resources/js/vendor/jquery.fancybox.min.js',
        __dirname + '/Resources/js/vendor/emojione.min.js',
        __dirname + '/Resources/js/vendor/emojionearea.min.js',
        __dirname + '/Resources/js/vendor/moment.min.js',
        __dirname + '/Resources/js/vendor/swiper.min.js',
        __dirname + '/Resources/js/vendor/Chart.min.js',
        __dirname + '/Resources/js/vendor/chartist.min.js',
        __dirname + '/Resources/js/vendor/jquery.dataTables.min.js',
        __dirname + '/Resources/js/vendor/all.js',
        __dirname + '/Resources/js/vendor/v4-shims.js',
    ], 'public_html/js/dashboard-app-vendor.js');

	mix.scripts([
        __dirname + '/Resources/js/vendor/rootui.js',
        __dirname + '/Resources/js/vendor/rootui-init.js',
    ], 'public_html/js/user-dashboard-init.js');

	mix.js(__dirname + '/Resources/js/app.js', 'js/dashboard-app.js')
}
