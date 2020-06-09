let fs = require('fs-extra');
let modules = fs.readdirSync('./main/app/Modules');
const mix = require('laravel-mix');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

require('laravel-mix-imagemin');
require('laravel-mix-svelte');
mix.setPublicPath('./public_html');

if (modules && modules.length > 0) {
	modules.forEach((module) => {
		let path = `./main/app/Modules/${module}/webpack.mix.js`;
		if (fs.existsSync(path)) {
			require(path);
		}
	});
}

// console.log(process.env);

mix.webpackConfig({
	output: {
		filename: "[name].[chunkhash].js",
		chunkFilename: "[name].[chunkhash].js",
	},
	plugins: [
    new CleanWebpackPlugin({
			dry: false,
			cleanOnceBeforeBuildPatterns: ['css/*', '/img/*', 'fonts/*'] //, './mix-manifest.json']

		}),
  ]
});

mix.options({
		fileLoaderDirs: {
			images: 'img'
		},
		postCss: [
		  require('postcss-fixes')(),
		  // require('cssnano')({
			// 	discardComments: {
			// 		removeAll: true
			// 	},
			// 	calc: false,
			// 	cssDeclarationSorter: true
			// })
		],
	})
	.mergeManifest()
	.imagemin(

		[
			{
				from: '**/img/**/**.*',
				to: 'img/[folder]/[name].[ext]',
				toType: 'template',
     },
			{
				from: '**/img/**.*',
				to: 'img/[name].[ext]',
				toType: 'template',
     }
    ], {
			context: './main/app/Modules',
		}, {
			optipng: {
				optimizationLevel: 7
			},
			jpegtran: null,
			plugins: [
                require('imagemin-mozjpeg')({
					quality: 75,
					progressive: true,
				}),
            ],
		}
	);
