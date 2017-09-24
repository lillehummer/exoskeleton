/**
 * [webpack description]
 * @type {[type]}
 */

let webpack = require('webpack')

require('dotenv').config({ path: __dirname + '/../../../.env' } )

let ManifestPlugin = require('webpack-manifest-plugin')
let CleanWebpackPlugin = require('clean-webpack-plugin')
let WebpackNotifierPlugin = require('webpack-notifier')

let config = {
  entry: {
    app: ['webpack-hot-middleware/client', './src/js/app.js'],
    vendor: ['jquery']
  },
  output: {
    filename: './js/[name].js',
    publicPath: 'http://localhost:3000/wp-content/themes/lillehummernl/'
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
      test: /\.scss$/,
        use: [
          'style-loader',
          {
            loader: 'css-loader',
            options: {
              url: false,
              minimize: false
            }
          },
          'postcss-loader',
          {
            loader: 'sass-loader',
            options: {
            }
          }
        ]
      },
      {
        test: /\.(png|jpe?g|gif|svg|eot|ttf|woff|woff2)$/,
        loader: 'url-loader',
        options: {
          limit: 10000
        }
      }
    ]
  },
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new WebpackNotifierPlugin(),
    new CleanWebpackPlugin(['css', 'js']),
    new ManifestPlugin({
        writeToFileEmit: true
    }),
    new webpack.DefinePlugin({
        'process.env': {
            NODE_ENV: '"development"'
        }
    })
  ],
  resolve: {
    modules: ['node_modules'],
    alias: {
      'vue$': 'vue/dist/vue.js'
    },
    extensions: ['.js', '.css', '.scss']
  },
  performance: {
    maxAssetSize: 2500000,
    maxEntrypointSize: 2500000
  }
}

module.exports = config
