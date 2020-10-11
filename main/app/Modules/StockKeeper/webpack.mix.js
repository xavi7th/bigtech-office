const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@stockkeeper-pages': __dirname + '/Resources/js/Pages',
				'@stockkeeper-shared': __dirname + '/Resources/js/Shared',
				'@stockkeeper-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/stockkeeper.js')
