// TODO:
// - Vendor bundling
// - OSX notifications
// - Hot module reloading
// - Friendly errors
// - Performance
// - Image optimisation, progressive JPG, SVGO
// - Prod/Dev plugins
// - More PostCSS
// - Lazy loading chunks
// - Extract plugin and Loader Options plugin
// - Sourcemaps
// - Base64 encode small images/icons
// - Remove old files with hash
// - Use Webpack Blocks

var webpack = require('webpack');
var path = require('path');

require('dotenv').config({path: __dirname + '/../../../.env'})

var UglifyJSPlugin = require('uglifyjs-webpack-plugin');
var ManifestPlugin = require('webpack-manifest-plugin');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var BrowserSyncPlugin = require('browser-sync-webpack-plugin');

var env = process.env.NODE_ENV || 'development';
var isProd = (env === 'production');

var config =  {
  entry: {
    app: ['./src/js/app.js', './src/css/style.scss']
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
