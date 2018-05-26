/**
 * [webpack description]
 * @type {[type]}
 */

let webpack = require('webpack')
let path = require('path')

let UglifyJsPlugin = require('uglifyjs-webpack-plugin')
let MiniCssExtractPlugin = require('mini-css-extract-plugin')
let OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
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
    filename: 'js/[name].[chunkhash].js',
    path: path.resolve(__dirname)
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
        use: [
          MiniCssExtractPlugin.loader,
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
        ]
      }
    ]
  },
  optimization: {
    concatenateModules: true,
    minimizer: [
      new UglifyJsPlugin({
        cache: true,
        parallel: true,
        sourceMap: true // set to true if you want JS source maps
      }),
      new OptimizeCSSAssetsPlugin({})
    ]
  },
  plugins: [
    new VueLoaderPlugin(),
    new CleanWebpackPlugin(['/js', '/css']),
    new MiniCssExtractPlugin({
      filename: 'css/[name].[chunkhash].css',
      chunkFilename: '[id].[chunkhash].css'
    }),
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
