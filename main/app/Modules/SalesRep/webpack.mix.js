const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@salesrep-pages': __dirname + '/Resources/js/Pages',
				'@salesrep-shared': __dirname + '/Resources/js/Shared',
				'@salesrep-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/salesrep.js')
