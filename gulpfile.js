const BrowserSync = require('browser-sync')

// Include Gulp
const gulp = require('gulp')

// Include plugins
const notify = require('gulp-notify')
const webpack = require('webpack')
const webpackDevMiddleware = require('webpack-dev-middleware')
const webpackHotMiddleware = require('webpack-hot-middleware')

const webpackConfig = require('./webpack.config')
const bundler = webpack(webpackConfig)

const browserSync = BrowserSync.create()

const localhost = 'http://lillehummernl.test'

// Error handler
const onError = function (err) {
  notify.onError({
    title: 'Error',
    message: err.message,
    sound: false
  })(err)

  gulpUtil.log(gulpUtil.colors.red(err))
  this.emit('end')
}

/**
 *
 */
gulp.task('dev', function () {
  browserSync.init({
    cors: true,
    notify: false,
    open: false,
    proxy: {
      target: localhost,
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
    ]
  })
})
