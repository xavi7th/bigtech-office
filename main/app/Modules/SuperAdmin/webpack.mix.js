// const dotenvExpand = require('dotenv-expand');
// dotenvExpand(require('dotenv')
// 	.config({
// 		path: __dirname + '/../../../.env',
// 	}));

const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@superadmin-pages': __dirname + '/Resources/js/Pages',
			'@superadmin-shared': __dirname + '/Resources/js/Shared',
			'@superadmin-assets': __dirname + '/Resources'
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/superadmin.js')
