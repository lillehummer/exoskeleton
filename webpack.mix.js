const { mix } = require('laravel-mix');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

mix.webpackConfig({
		plugins: [
			new BrowserSyncPlugin({
				open: 'external',
				host: 'debuurtcampingnl-gids.dev',
				proxy: 'debuurtcampingnl-gids.dev',
				files: ['*.php']
			})
		]
	})
    .autoload({
	   jquery: ['$', 'window.jQuery', 'jQuery'],
	   vue: 'vue'
	})
	.sourceMaps()
	.extract(['vue', 'jquery'])
   	.js('src/js/app.js', 'js')
   	.sass('src/css/style.scss', 'css');
   	//.version();
