/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const mix = require('laravel-mix');
const autoPreprocess = require('svelte-preprocess');

require('laravel-mix-svelte');

mix.setPublicPath('./public_html');

let fs = require('fs-extra');

let modules = fs.readdirSync('./main/app/Modules'); // Make sure the path of your modules are correct

if (modules && modules.length > 0) {
	modules.forEach((module) => {
		let path = `./main/app/Modules/${module}/webpack.mix.js`;
		if (fs.existsSync(path)) {
			require(path);
		}
	});
}

mix.webpackConfig({
	output: {
		chunkFilename: '[name].js?id=[chunkhash]',
	},
	resolve: {
		alias: {
			ziggy: path.resolve('./main/vendor/tightenco/ziggy/dist/js/route.js'),
		},
	},
});

mix.babelConfig({
	plugins: ['@babel/plugin-syntax-dynamic-import'],
});

mix
	.options({
		fileLoaderDirs: {
			images: 'img'
		},
	})
	.svelte({
		dev: !mix.inProduction(),
		css: true,
		preprocess: autoPreprocess(),
		onwarn: (warning, handler) => {
			const {
				code,
				frame
			} = warning;

			if (code == "anchor-is-valid" || code == "a11y-invalid-attribute") {
				return
			}
			if (code == "css-unused-selector") {
				return
			}
			if (code == 'css-unused-selector' && frame.includes('sweetalert')) {
				return
			}

			console.log(
				'\x1b[41m%s\x1b[0m',
				code
			)

			handler(warning);
		}
	})
	.extract()
	.mergeManifest();

if (mix.inProduction()) {
	mix.version()
		.then(() => {
			const convertToFileHash = require("laravel-mix-make-file-hash");
			convertToFileHash({
				publicPath: "./public_html",
				manifestFilePath: "./public_html/mix-manifest.json",
				blacklist: ["user-*", "public*", "super-*"],
				keepBlacklistedEntries: true,
				// debug: true
			});
		});
}

if (!mix.inProduction()) {
	mix.sourceMaps()
}
