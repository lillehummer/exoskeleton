// TODO:
// - Hot module reloading
// - Performance
// - Image optimisation, progressive JPG, SVGO
// - More PostCSS
// - Base64 encode small images/icons
// - https://github.com/th0r/webpack-bundle-analyzer

let webpack = require('webpack');

require('dotenv').config({ path: __dirname + '/../../../.env' } );

let UglifyJSPlugin = require('uglifyjs-webpack-plugin');
let ManifestPlugin = require('webpack-manifest-plugin');
let ExtractTextPlugin = require('extract-text-webpack-plugin');
let BrowserSyncPlugin = require('browser-sync-webpack-plugin');
let CleanWebpackPlugin = require('clean-webpack-plugin');
let WebpackNotifierPlugin = require('webpack-notifier');

let config = {
  entry: {
    app: ['./src/js/app.js'],
    vendor: ['jquery', 'vue', 'vuex', 'vue-router', 'vuex-router-sync', 'gsap', 'lodash']
  },
  output: {
    filename: './js/[name].[hash].js'
  },
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
    new webpack.optimize.CommonsChunkPlugin('vendor'),
    new WebpackNotifierPlugin({ alwaysNotify: true }),
    new CleanWebpackPlugin(['css', 'js']),
    new ManifestPlugin(),
    new ExtractTextPlugin('./css/style.[hash].css'),
    new UglifyJSPlugin({
      mangle: {
        except: ['$', 'exports', 'require', 'import']
      }
    })
  ],
  resolve: {
    modules: ['node_modules'],
    alias: {
      'vue$': 'vue/dist/vue.js'
    }
  },
  performance: {
    maxAssetSize: 2500000,
    maxEntrypointSize: 2500000
  }
};

module.exports = config;
