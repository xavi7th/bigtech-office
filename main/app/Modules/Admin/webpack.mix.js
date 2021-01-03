const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@admin-pages': __dirname + '/Resources/js/Pages',
			'@admin-shared': __dirname + '/Resources/js/Shared',
				'@admin-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/admin.js')
mix.sass(__dirname + '/Resources/sass/app.scss', 'css/admin-app.css')
