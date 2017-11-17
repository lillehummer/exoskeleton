/**
 * [webpack description]
 * @type {[type]}
 */

let webpack = require('webpack')

require('dotenv').config({ path: __dirname + '/../../../.env' } )

let UglifyWebpackPlugin = require('uglifyjs-webpack-plugin')
let ManifestPlugin = require('webpack-manifest-plugin')
let ExtractTextPlugin = require('extract-text-webpack-plugin')
let CleanWebpackPlugin = require('clean-webpack-plugin')
let WebpackNotifierPlugin = require('webpack-notifier')
var BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

let config = {
  entry: {
    app: ['./src/js/app.js'],
    vendor: ['jquery'],
    login: ['./src/css/login.scss']
  },
  output: {
    filename: './js/[name].[chunkhash].js'
  },
  externals: { jquery: "jQuery" },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: [/(node_modules|bower)/],
        use: [{
          loader: 'buble-loader',
          options: { objectAssign: 'Object.assign' }
        }]
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      },
      {
        test: /\.(scss)$/,
        use: ExtractTextPlugin.extract([
            {
                loader: 'css-loader',
                options: {
                    url: false,
                    minimize: true
                },
            },
            'postcss-loader',
            {
              loader: 'sass-loader',
              options: {
              }
            }
        ])
        },
    ],
  },
  plugins: [
  	new webpack.optimize.ModuleConcatenationPlugin(),
    new webpack.optimize.CommonsChunkPlugin({
        name: "vendor.js",
        minChunks: module => /node_modules/.test(module.resource)
    }),
    new WebpackNotifierPlugin(),
    new CleanWebpackPlugin(['css', 'js']),
    new ManifestPlugin(),
    new ExtractTextPlugin('./css/[name].[chunkhash].css'),
    new UglifyWebpackPlugin(),
    new BundleAnalyzerPlugin({
        analyzerMode: 'static'
    }),
    new webpack.DefinePlugin({
        'process.env': {
            NODE_ENV: '"production"'
        }
    })
  ],
  resolve: {
    modules: ['node_modules'],
    alias: {
        'vue$': 'vue/dist/vue.esm.js'
    }
  },
  performance: {
    maxAssetSize: 2500000,
    maxEntrypointSize: 2500000
  }
}

module.exports = config
