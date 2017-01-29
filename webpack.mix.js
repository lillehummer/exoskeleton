let mix = require('laravel-mix');

mix.setPublicPath('/')
	.autoload({
	   jquery: ['$', 'window.jQuery', 'jQuery'],
	   vue: 'vue'
	})
	.extract(['vue', 'jquery'])
   	.js('src/app.js', 'dist')
   	.sass('src/app.scss', 'dist');
