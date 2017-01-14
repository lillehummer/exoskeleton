var webpack = require('webpack');
var path = require('path');

module.exports =  {
  output: {
    filename: 'app.js'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: [/(node_modules|bower_components)(?![/|\\](bootstrap|foundation-sites))/],
        use: [{
          loader: 'buble-loader',
          options: { objectAssign: 'Object.assign' },
        }]
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      }
    ]
  },
  resolve: {
    modules: ['node_modules']
  }
};
