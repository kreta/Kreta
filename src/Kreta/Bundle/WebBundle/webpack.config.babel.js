/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Autoprefixer from 'autoprefixer';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import Webpack from 'webpack';

import pkg from './package.json';

let buildPath = './../../../../../../web';
if (process.argv[4] === '--from-vendor') {
  buildPath = './../../../../../../../web';
}

const SOURCE_PATH = './Resources/public',
  LICENSE = `${pkg.name} - ${pkg.description}
Authors: ${pkg.authors[0].name} - ${pkg.authors[1].name}
Url: ${pkg.homepage}
License: ${pkg.license}`,
  config = {
    debug: false,
    devtool: 'eval',
    context: __dirname,
    entry: {
      app: `${SOURCE_PATH}/js/Kreta.js`,
      login: `${SOURCE_PATH}/js/Login.js`,
      vendors: [
        'classnames',
        'lodash',
        'mousetrap',
        'react',
        'react-dom',
        'react-quill',
        'react-redux',
        'react-router',
        'react-router-redux',
        'redux',
        'redux-logger',
        'redux-thunk'
      ]
    },
    output: {
      path: `${buildPath}/js`, filename: '[name].js'
    },
    module: {
      loaders: [
        {test: /\.js(x)?$/, exclude: /node_modules/, loaders: ['babel']},
        {test: /\.(jpe?g|png|gif|ico)$/, loader: 'file?name=../images/[hash].[ext]'},
        {test: /\.svg$/, loader: 'svg-sprite?name=[name]_[hash].svg'},
        {
          test: /\.s?css$/, loader: ExtractTextPlugin.extract(
            'style', 'css!postcss!sass?outputStyle=expanded&sourceComments=true'
          )
        }
      ],
      noParse: /node_modules\/quill\/dist\/quill.js/
    },
    resolve: {
      alias: {underscore: 'lodash'},
      extensions: ['', '.js', '.jsx', '.svg', '.scss', '.css']
    },
    postcss: [Autoprefixer()],
    plugins: [
      new Webpack.ProvidePlugin({
        'Promise': 'es6-promise',
        'fetch': 'imports?this=>global!exports?global.fetch!whatwg-fetch'
      }),
      new Webpack.optimize.CommonsChunkPlugin('vendors', 'vendor.js'),
      new ExtractTextPlugin('../css/[name].css', {allChunks: false}),
      new Webpack.BannerPlugin(LICENSE)
    ]
  };

if (process.env.NODE_ENV !== 'production') {
  config['eslint'] = {configFile: '.eslintrc.js'};
  config['stylelint'] = {configFile: '.stylelintrc.js'};

  config['module']['preLoaders'] = [
    {test: /\.js(x)?$/, exclude: /node_modules/, loaders: ['eslint']},
    {test: /\.s?css$/, loaders: ['stylelint']}
  ];
}

if (process.env.NODE_ENV === 'production') {
  config.debug = false;
  config.devtool = 'source-map';
  config.plugins.push(new Webpack.optimize.UglifyJsPlugin({
    compress: {
      warnings: true
    }
  }));
  config.plugins.push(new Webpack.DefinePlugin({
    'process.env': {
      'NODE_ENV': JSON.stringify('production')
    }
  }));
  config.module.loaders.push(
    {test: /\[name].css$/, loader: 'style-loader/useable!css-loader?minimize!postcss-loader'}
  );
}

export default config;
