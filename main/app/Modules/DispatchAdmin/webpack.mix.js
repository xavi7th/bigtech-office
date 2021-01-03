const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@dispatchadmin-pages': __dirname + '/Resources/js/Pages',
				'@dispatchadmin-shared': __dirname + '/Resources/js/Shared',
				'@dispatchadmin-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/dispatchadmin.js')
mix.sass(__dirname + '/Resources/sass/app.scss', 'css/dispatch-admin-app.css')
