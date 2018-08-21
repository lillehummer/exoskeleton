/**
 * [webpack description]
 * @type {[type]}
 */

let webpack = require('webpack')
let path = require('path')

let ImageminPlugin = require('imagemin-webpack-plugin').default
let CopyWebpackPlugin = require('copy-webpack-plugin')
let { VueLoaderPlugin } = require('vue-loader')
let ManifestPlugin = require('webpack-manifest-plugin')

let config = {
  mode: 'development',
  entry: {
    app: ['webpack-hot-middleware/client', './src/js/app.js']
  },
  output: {
    filename: 'js/[name].js',
    publicPath: '/wp-content/themes/lillehummernl/'
  },
  externals: {
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
        test: /\.scss$/,
        use: [
          'style-loader',
          {
            loader: 'css-loader',
            options: {
              url: true,
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
  devtool: 'source-map',
  plugins: [
    new VueLoaderPlugin(),
    new ManifestPlugin({
      fileName: path.resolve(__dirname, './manifest.json'),
      publicPath: '',
      writeToFileEmit: true
    }),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: '"development"'
      }
    }),
    new CopyWebpackPlugin([{
      from: 'src/img/',
      to: 'img/'
    }]),
    new ImageminPlugin({
      test: /\.(jpe?g|png|gif|svg)$/i,
      pngquant: {
        quality: '95-100'
      },
      svgo: {
        removeViewBox: false
      },
      jpegtran: {
        progressive: true
      }
    })
  ],
  resolve: {
    modules: ['node_modules'],
    alias: {
    },
    extensions: ['.js', '.css', '.scss']
  },
  performance: {
    maxAssetSize: 2500000,
    maxEntrypointSize: 2500000
  }
}

module.exports = config
