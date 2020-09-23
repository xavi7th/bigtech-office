const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@userpages': __dirname + '/Resources/js/Pages',
			'@usershared': __dirname + '/Resources/js/Shared',
			'@userassets': __dirname + '/Resources'
		},
	},
})

mix.scripts([
        __dirname + '/Resources/js/vendor/jquery.min.js',
        __dirname + '/Resources/js/vendor/popper.min.js',
        __dirname + '/Resources/js/vendor/bootstrap.min.js',
        __dirname + '/Resources/js/vendor/feather.min.js',
        // __dirname + '/Resources/js/vendor/jquery.overlayScrollbars.min.js',
        __dirname + '/Resources/js/vendor/yaybar.js',
        __dirname + '/Resources/js/vendor/ofi.min.js',
        __dirname + '/Resources/js/vendor/jquery.fancybox.min.js',
        __dirname + '/Resources/js/vendor/swiper.min.js',
        // __dirname + '/Resources/js/vendor/Chart.min.js',
        // __dirname + '/Resources/js/vendor/chartist.min.js',
        __dirname + '/Resources/js/vendor/datatables/datatables.js',
        // __dirname + '/Resources/js/vendor/jquery.dataTables.min.js',
        __dirname + '/Resources/js/vendor/all.js',
        __dirname + '/Resources/js/vendor/v4-shims.js',
    ], 'public_html/js/dashboard-app-vendor.js');

mix.scripts([
        __dirname + '/Resources/js/vendor/rootui.js',
        __dirname + '/Resources/js/vendor/rootui-init.js',
    ], 'public_html/js/user-dashboard-init.js');

mix.js(__dirname + '/Resources/js/app.js', 'js/dashboard-app.js')
