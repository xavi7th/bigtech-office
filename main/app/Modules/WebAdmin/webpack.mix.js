const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@webadmin-pages': __dirname + '/Resources/js/Pages',
				'@webadmin-shared': __dirname + '/Resources/js/Shared',
				'@webadmin-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/webadmin.js')
mix.sass(__dirname + '/Resources/sass/app.scss', 'css/webadmin-app.css')
