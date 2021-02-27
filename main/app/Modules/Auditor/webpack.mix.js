const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@auditor-pages': __dirname + '/Resources/js/Pages',
			'@auditor-shared': __dirname + '/Resources/js/Shared',
				'@auditor-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/auditor.js')
mix.sass(__dirname + '/Resources/sass/app.scss', 'css/auditor-app.css')
