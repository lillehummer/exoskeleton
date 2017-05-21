// TODO:
// - Hot module reloading
// - Performance
// - Image optimisation, progressive JPG, SVGO
// - Prod/Dev plugins
// - More PostCSS
// - Base64 encode small images/icons
// - https://github.com/th0r/webpack-bundle-analyzer

var webpack = require('webpack');
var path = require('path');

require('dotenv').config({path: __dirname + '/../../../.env'})

var UglifyJSPlugin = require('uglifyjs-webpack-plugin');
var ManifestPlugin = require('webpack-manifest-plugin');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var BrowserSyncPlugin = require('browser-sync-webpack-plugin');
var CleanWebpackPlugin = require('clean-webpack-plugin');
var WebpackNotifierPlugin = require('webpack-notifier');

var env = process.env.NODE_ENV || 'development';
var isProd = (env === 'production');

var config =  {
  entry: {
    app: ['./src/js/app.js', './src/css/style.scss'],
    vendor: ['jquery']
  },
  output: {
    filename: isProd ? './js/[name].[hash].js' : './js/[name].js'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: [/(node_modules|bower)/],
        use: [{
          loader: 'buble-loader',
          options: { objectAssign: 'Object.assign' },
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
                minimize: isProd ? true : false
              }
            },
            'postcss-loader',
            {
              loader: "sass-loader", options: {
              }
            }
          ])
        }
    ]
  },
  plugins: [
    new WebpackNotifierPlugin({alwaysNotify: true}),
    new CleanWebpackPlugin(['css', 'js']),
    new ManifestPlugin(),
    new ExtractTextPlugin( isProd ? './css/style.[hash].css' : './css/style.css' ),
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      proxy: process.env.PROXY,
      notify: false,
      cors: true,
      snippetOptions: {
        rule: {
          match: /<\/head>/i,
          fn: function (snippet, match) {
            return snippet + match;
          }
        }
      },
      files: ['./css/style.css', './*.php', './**/*.php', './**/**/*.php']
    })
  ],
  resolve: {
    modules: ['node_modules']
  },
  performance: {
    maxAssetSize: 2500000,
    maxEntrypointSize: 2500000
  },
  devServer: {
    headers: {
        "Access-Control-Allow-Origin": "*"
    },
    historyApiFallback: true,
    noInfo: true,
    compress: true,
    quiet: true
  }
};

if ( isProd ) {
    config.plugins.push(
        new UglifyJSPlugin({
          mangle: {
            except: ['$', 'exports', 'require', 'import']
          }
        })
    );
}

module.exports = config;
