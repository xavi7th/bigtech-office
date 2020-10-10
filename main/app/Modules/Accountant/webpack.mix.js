const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@accountant-pages': __dirname + '/Resources/js/Pages',
				'@accountant-shared': __dirname + '/Resources/js/Shared',
				'@accountant-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/accountant.js')
