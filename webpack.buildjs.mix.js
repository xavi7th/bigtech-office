const MomentLocalesPlugin = require('moment-locales-webpack-plugin');
const mix = require('laravel-mix');
const autoPreprocess = require('svelte-preprocess');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

require('laravel-mix-svelte');

mix.setPublicPath('./public_html');

let fs = require('fs-extra');
let modules = fs.readdirSync('./main/app/Modules');

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
		filename: "[name].[chunkhash].js",
		chunkFilename: "[name].[chunkhash].js",
	},
	resolve: {
		alias: {
			ziggy: path.resolve('./main/vendor/tightenco/ziggy/dist/js/route.js'),
		},
	},
	plugins: [
  /**
  * To strip all locales except“ en”
  */
  new MomentLocalesPlugin(),
    new CleanWebpackPlugin({
			dry: false,
			cleanOnceBeforeBuildPatterns: ['js/*', './*.js', 'robots.txt']

		}),
  ]
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
	.mergeManifest()
	.then(() => {
		const _ = require('lodash')
		// let manifestData = require( './public_html/mix-manifest' )
		let oldManifestData = JSON.parse(fs.readFileSync('./public_html/mix-manifest.json', 'utf-8'))
		let newManifestData = {};

		_.map(oldManifestData, (actualFilename, mixKeyName) => {
			if (_.startsWith(mixKeyName, '/css')) {
				/** Exclude CSS files from renaming for now till we start cache busting them */
				newManifestData[mixKeyName] = actualFilename;
			} else {
				let newMixKeyName = _.split(mixKeyName, '.')
					.tap(o => {
						_.pullAt(o, 1);
					})
					.join('.')

				/** If the js extension has been stripped we add it back */
				newMixKeyName = _.endsWith(newMixKeyName, '.js') ? newMixKeyName : newMixKeyName + '.js'

				newManifestData[newMixKeyName] = actualFilename;
			}

		});

		let data = JSON.stringify(newManifestData, null, 2);
		fs.writeFileSync('./public_html/mix-manifest.json', data);
	})

if (!mix.inProduction()) {
	mix.sourceMaps()
}
