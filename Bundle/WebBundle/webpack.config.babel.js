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
      'select2',
      'mousetrap'
    ]
  },
  output: {
    path: path.resolve(__dirname, '../../../../web/js'),
    filename: 'kreta.js'
  },
  module: {
    preLoaders: [{
      test: /\.js$/,
      exclude: /node_modules/,
      loaders: [
        'eslint-loader'
      ]
    }],
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
  eslint: {
    configFile: '.eslint.yml'
  },
  plugins: [
    new webpack.ProvidePlugin({
      _: 'lodash',
      Backbone: 'backbone',
      $: 'jquery',
      jQuery: 'jquery'
    }),
    new webpack.optimize.CommonsChunkPlugin('vendorsJS', 'vendors.js')
  ]
};

export default config;
