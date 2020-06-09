const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv')
	.config({
		path: __dirname + '/../../../.env',
	}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

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

if (['buildcss'].includes(process.env.npm_config_section)) {
	// mix.copyDirectory(__dirname + '/Resources/img', 'public_html/img');
	// mix.copyDirectory(__dirname + '/Resources/fonts', 'public_html/fonts');

	mix.sass(__dirname + '/Resources/sass/app.scss', 'css/superadmin.css');
} else {
	mix.js(__dirname + '/Resources/js/app.js', 'js/superadmin.js')
}
