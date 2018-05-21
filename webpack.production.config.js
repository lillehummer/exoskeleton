/**
 * [webpack description]
 * @type {[type]}
 */

let webpack = require('webpack')
let path = require('path')

let ExtractTextPlugin = require('extract-text-webpack-plugin')
let CleanWebpackPlugin = require('clean-webpack-plugin')
let ManifestPlugin = require('webpack-manifest-plugin')
var BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin
let WebpackMonitor = require('webpack-monitor')
let { VueLoaderPlugin } = require('vue-loader')

let config = {
  mode: 'production',
  entry: {
    app: ['./src/js/app.js']
  },
  output: {
    filename: './js/[name].[chunkhash].js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: [/(node_modules|bower)/],
        use: [{
          loader: 'babel-loader'
        }]
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        options: {
          loaders: {
            js: 'babel-loader'
          }
        }
      },
      {
        test: /\.(scss)$/,
        use: ExtractTextPlugin.extract([
          {
            loader: 'css-loader',
            options: {
              url: false,
              minimize: true
            }
          },
          'postcss-loader',
          {
            loader: 'sass-loader',
            options: {
            }
          }
        ])
      }
    ]
  },
  optimization: {
    concatenateModules: true
  },
  plugins: [
    new VueLoaderPlugin(),
    new CleanWebpackPlugin(['/static/css', '/static/js']),
    new ExtractTextPlugin('./css/[name].[chunkhash].css'),
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: '"production"'
      }
    }),
    new ManifestPlugin({
      fileName: path.resolve(__dirname, './manifest.json'),
      publicPath: ''
    }),
    new WebpackMonitor({
      capture: true,
      launch: true
    }),
    new BundleAnalyzerPlugin()
  ],
  resolve: {
    modules: ['node_modules'],
    alias: {
      'vue$': 'vue/dist/vue.runtime.js',
      utilities: path.resolve(__dirname, 'src/js/utils/')
    }
  },
  performance: {
    maxAssetSize: 2500000,
    maxEntrypointSize: 2500000
  }
}

module.exports = config
