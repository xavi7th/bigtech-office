const dotenvExpand = require( 'dotenv-expand' );
dotenvExpand( require( 'dotenv' ).config( {
    path: __dirname + '/../../../.env',
    // debug: true
} ) );

// console.log( process.env );

const mix = require( 'laravel-mix' );
require( 'laravel-mix-merge-manifest' );

mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.svelte', '.json' ],
        alias: {
            '@admin-pages': __dirname + '/Resources/js/Pages',
            '@admin-assets': __dirname + '/Resources'
        },
    },
} )

// mix.scripts( [
//     __dirname + '/Resources/js/vendor/jquery-3.2.1.min.js',
//     __dirname + '/Resources/js/vendor/popper.min.js',
//     __dirname + '/Resources/js/vendor/bootstrap.min.js',
//     __dirname + '/Resources/js/vendor/simplebar.min.js',
//     __dirname + '/Resources/js/vendor/jquery.dataTables.min.js',
//     __dirname + '/Resources/js/vendor/dataTables.responsive.min.js',
//     __dirname + '/Resources/js/vendor/chartjs.min.js',
//     __dirname + '/Resources/js/vendor/morris.min.js',
//     __dirname + '/Resources/js/vendor/jquery.sparkline.min.js',
//     __dirname + '/Resources/js/vendor/js/jquery.peity.min.js',
//     __dirname + '/Resources/js/vendor/raphael.min.js',
// ], 'public_html/js/admin-app-vendor.js' );


// mix.scripts( [
//     __dirname + '/Resources/js/vendor/index.js'
// ], 'public_html/js/admin-dashboard.js' );

// mix.scripts( [
//     __dirname + '/Resources/js/vendor/main.js'
// ], 'public_html/js/admin-nav.js' );

// mix.copyDirectory( __dirname + '/Resources/img', 'public_html/img' );
// mix.copyDirectory( __dirname + '/Resources/fonts', 'public_html/fonts' );

if ( [ 'buildcss' ].includes( process.env.npm_config_section ) ) {
    mix.sass( __dirname + '/Resources/sass/app.scss', 'css/admin.css' );
} else {
    mix.js( __dirname + '/Resources/js/app.js', 'js/admin.js' )
}
