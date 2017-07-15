var browserSync = require('browser-sync').create();
var webpack = require('webpack');
var webpackDevMiddleware = require('webpack-dev-middleware');
var webpackHotMiddleware = require('webpack-hot-middleware');

var webpackConfig = require('../webpack.config');
var bundler = webpack(webpackConfig);

var LOCAL_HOST = "http://lillehummernl.dev";

browserSync.init({
	cors: true,
    notify: false,
    proxy: {
      target: LOCAL_HOST,
      ws: true,
      middleware: [
        webpackDevMiddleware(bundler, {
          publicPath: webpackConfig.output.publicPath,
          stats: { colors: true }
        }),
        webpackHotMiddleware(bundler)
      ]
    },
    files: [
      '*.php',
      './**/*.php',
      './**/**/*.php'
    ],
    snippetOptions: {
		rule: {
			match: /<\/head>/i,
			fn(snippet, match) {
				return snippet + match;
			}
		}
	}
});
