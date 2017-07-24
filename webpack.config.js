
// Plugins and such
const webpack = require('webpack');
const extractCSS = require("extract-text-webpack-plugin");
const browserSyncPlugin = require('browser-sync-webpack-plugin');
const themePath = __dirname + '/public_html/wp-content/themes/CHANGEME/';

module.exports = function(env){

	// Check for production flag
	var PROD = process.env.NODE_ENV == 'production';

	return {

		// Sourcemaps: simpler and faster one for development, slower and more secure one for production
		devtool: PROD ? 'source-map' : 'cheap-module-eval-source-map',

		// File extensions that can be omitted in import and require statements
		resolve: {
			extensions: [
				'.js',
				'.json'
			]
		},

		// Entry point(s)
		entry: {
			app: themePath + 'src/js/app.js',
			styles: themePath + 'src/css/theme.scss'
		},

		// Destination for bundles
		output: {
			filename: '[name].js',
			path: PROD ? themePath + 'build' : themePath + 'dist'
		},

		// Rules for bundling
		module: {

			rules: [

				// Linting
				{
					enforce: 'pre', // Lint before Babel
					test: /\.js$/,
					include:  themePath + 'src/js',
					loader: 'eslint-loader',
					options: {
						// Use stricter linting rules when building for production
						configFile: PROD ? __dirname + '/.eslintrc-prod' : __dirname + '/.eslintrc'
					}
				},

				// Babel for ES6
				{
					test: /\.js$/,
					include:  themePath + 'src/js',
					loader: 'babel-loader'
				},

				// SCSS
				{
					test: /\.scss$/,
					exclude:  __dirname + '/node_modules',
					loader: extractCSS.extract({
						fallback: 'style-loader',
						use: 'css-loader?-url!sass-loader',
					})
				}
			]
		},

		plugins: [

			// Create static SCSS file from resulting bundle, instead of injecting into JS
			new extractCSS("styles.css"),

			// Used for uglifying
			new webpack.LoaderOptionsPlugin({
				minimize: true,
				debug: false
			}),

			// Uglify JS
			new webpack.optimize.UglifyJsPlugin({
				beautify: false,
				mangle: {
					screw_ie8: true,
					keep_fnames: true
				},
				compress: {
					screw_ie8: true
				},
				comments: false
			}),

			// Browser sync
			new browserSyncPlugin({
				open: 'external',
				host: 'starterpack.madwell.walt',
				proxy: 'starterpack.madwell.walt',
				port: 3000
			})
		]
	}
};
