const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@qualitycontrol-pages': __dirname + '/Resources/js/Pages',
				'@qualitycontrol-shared': __dirname + '/Resources/js/Shared',
				'@qualitycontrol-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/qualitycontrol.js')
