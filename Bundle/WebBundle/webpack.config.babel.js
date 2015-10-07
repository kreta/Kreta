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

const CLI_OPTIONS = minimist(process.argv),
  SOURCE_PATH = path.resolve(__dirname, 'Resources/public'),
  BUILD_PATH = path.resolve(__dirname, '../../../../web'),
  LICENSE = `${pkg.name} - ${pkg.description}
Authors: ${pkg.authors[0].name} - ${pkg.authors[1].name}
Url: ${pkg.homepage}
License: ${pkg.license}`;

let config = {
  debug: false,
  devtool: 'eval',
  entry: {
    js: `${SOURCE_PATH}/js/kreta.js`,
    vendors: [
      'jquery', 'lodash', 'backbone', 'backbone-model-file-upload', 'backbone.marionette', 'select2', 'mousetrap'
    ]
  },
  output: {
    path: `${BUILD_PATH}/js`, filename: 'kreta.js', publicPath: '/Resources/public'
  },
  module: {
    preLoaders: [
      {test: /\.js$/, exclude: /node_modules/, loaders: ['eslint']}
    ],
    loaders: [
      {test: /\.js$/, exclude: /node_modules/, loaders: ['babel']},
      {test: /\.(jpe?g|png|gif|svg|ico|pdf)$/i, loader: 'url-loader?limit=8192'},
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
    new webpack.optimize.CommonsChunkPlugin('vendors', 'vendors.js'),
    new ExtractTextPlugin('../css/kreta.css', {allChunks: false}),
    new webpack.BannerPlugin(LICENSE)
  ]
};

if (CLI_OPTIONS.hasOwnProperty('env') && CLI_OPTIONS.env === 'prod') {
  config.debug = false;
  config.devtool = 'source-map';
  config.plugins.push(new webpack.optimize.UglifyJsPlugin());
  config.output.filename = 'kreta.min.js';
  config.module.loaders.push(
    {test: /\.css$/, loader: 'style-loader/useable!css-loader?minimize!postcss-loader'}
  );
}

// This line should be remove when the whole js structure will be under React
copy.sync(`${SOURCE_PATH}/img`, `${BUILD_PATH}/images`);

export default config;
