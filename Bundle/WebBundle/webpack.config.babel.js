import path from 'path';
import webpack from 'webpack';

const config = {
  entry: {
    appJS: path.resolve(__dirname, 'Resources/public/js/kreta.js'),
    vendorsJS: [
      'jquery',
      'lodash',
      'backbone',
      'backbone-model-file-upload',
      'backbone.marionette',
      'react',
      'react-router',
      'select2',
      'mousetrap'
    ]
  },
  output: {
    path: path.resolve(__dirname, '../../../../web/js'),
    filename: 'kreta.js'
  },
  module: {
    loaders: [{
      test: /\.js$/,
      exclude: /node_modules/,
      loader: 'babel'
    }]
  },
  resolve: {
    alias: {
      underscore: 'lodash'
    }
  },
  plugins: [
    new webpack.ProvidePlugin({
      React: 'react',
      _: 'lodash',
      Backbone: 'backbone',
      $: 'jquery',
      jQuery: 'jquery'
    }),
    new webpack.optimize.CommonsChunkPlugin('vendorsJS', 'vendors.js')
  ]
};

export default config;
