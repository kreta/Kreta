/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import autoprefixer from 'autoprefixer';
import copy from 'copy-dir';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import minimist from 'minimist';
import path from 'path';
import webpack from 'webpack';

import pkg from './package.json';

const cliOptions = minimist(process.argv),
  LICENSE = `${pkg.name} - ${pkg.description}
Authors: ${pkg.authors[0].name} - ${pkg.authors[1].name}
Url: ${pkg.homepage}
License: ${pkg.license}`;

let config = {
  debug: false,
  devtool: 'eval',
  entry: {
    js: path.resolve(__dirname, 'Resources/public/js/kreta.js'),
    app: path.resolve(__dirname, 'Resources/public/scss/app.scss'),
    login: path.resolve(__dirname, 'Resources/public/scss/login.scss'),
    vendorsJS: [
      'jquery', 'lodash', 'backbone', 'backbone-model-file-upload', 'backbone.marionette', 'select2', 'mousetrap'
    ]
  },
  output: {
    path: path.resolve(__dirname, '../../../../web/js'), filename: 'kreta.js'
  },
  module: {
    preLoaders: [
      {test: /\.js$/, exclude: /node_modules/, loaders: ['eslint']}
    ],
    loaders: [
      {test: /\.js$/, exclude: /node_modules/, loaders: ['babel']},
      {test: /\.scss$/, loader: ExtractTextPlugin.extract(
        'style', 'css!postcss!sass?outputStyle=expanded&sourceComments=true'
      )}
    ]
  },
  resolve: {
    alias: {underscore: 'lodash'}
  },
  eslint: {configFile: '.eslint.yml'},
  postcss: [autoprefixer()],
  plugins: [
    new webpack.ProvidePlugin({
      _: 'lodash', Backbone: 'backbone', $: 'jquery', jQuery: 'jquery'
    }),
    new webpack.optimize.CommonsChunkPlugin('vendorsJS', 'vendors.js'),
    new webpack.BannerPlugin(LICENSE),
    new ExtractTextPlugin('../css/[name].css', {allChunks: false})
  ]
};

if (cliOptions.hasOwnProperty('env') && cliOptions.env === 'prod') {
  config.debug = false;
  config.devtool = 'source-map';
  config.plugins.push(new webpack.optimize.UglifyJsPlugin());
  config.output.filename = 'kreta.min.js';
  config.module.loaders.push(
    {test: /\.css$/, loader: 'style-loader/useable!css-loader?minimize!postcss-loader'}
  );
}
copy.sync(path.resolve(__dirname, 'Resources/public/img'), path.resolve(__dirname, '../../../../web/images'));

export default config;
