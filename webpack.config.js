// TODO:
// - Hot module reloading
// - Performance
// - Image optimisation, progressive JPG, SVGO
// - Prod/Dev plugins
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

let env = process.env.NODE_ENV || 'development';
let isProd = (env === 'production');

let config = {
  entry: {
    app: ['./src/js/app.js', './src/css/style.scss'],
    vendor: ['jquery', 'vue', 'vuex', 'vue-router', 'vuex-router-sync', 'gsap', 'lodash']
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
                    minimize: isProd
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
    new webpack.optimize.CommonsChunkPlugin('vendor'),
    new WebpackNotifierPlugin({ alwaysNotify: true }),
    new CleanWebpackPlugin(['css', 'js']),
    new ManifestPlugin(),
    new ExtractTextPlugin(isProd ? './css/style.[hash].css' : './css/style.css'),
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      proxy: process.env.PROXY,
      notify: false,
      cors: true,
      snippetOptions: {
        rule: {
          match: /<\/head>/i,
          fn(snippet, match) {
            return snippet + match;
          }
        }
      },
      files: ['./*.php', './**/*.php', './**/**/*.php']
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
  },
  devServer: {
    headers: {
        'Access-Control-Allow-Origin': '*'
    },
    historyApiFallback: true,
    noInfo: true,
    compress: true,
    quiet: true
  }
};

if (isProd) {
    config.plugins.push(
        new UglifyJSPlugin({
          mangle: {
            except: ['$', 'exports', 'require', 'import']
          }
        })
    );
}

module.exports = config;
