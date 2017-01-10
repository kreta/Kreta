/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

process.env.NODE_ENV = 'production';

import CaseSensitivePathsPlugin from 'case-sensitive-paths-webpack-plugin';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import HtmlWebpackPlugin from 'html-webpack-plugin';
import InterpolateHtmlPlugin from 'react-dev-utils/InterpolateHtmlPlugin';
import WatchMissingNodeModulesPlugin from 'react-dev-utils/WatchMissingNodeModulesPlugin';

import autoprefixer from 'autoprefixer';
import path from 'path';
import url from 'url';
import webpack from 'webpack';

import ensureSlash from './../devUtils/ensureSlash';
import paths from './paths';
import _env from './env';

const
  HOMEPAGE_PATH = require(paths.appPackageJson).homepage,
  HOMEPAGE_PATHNAME = HOMEPAGE_PATH ? url.parse(HOMEPAGE_PATH).pathname : '/';

const
  PUBLIC_PATH = ensureSlash(HOMEPAGE_PATHNAME, true),
  PUBLIC_URL = ensureSlash(HOMEPAGE_PATHNAME, false);

const env = _env(PUBLIC_URL);

if (env['process.env'].NODE_ENV !== '"production"') {
  throw new Error('Production builds must have NODE_ENV=production.');
}

export default {
  bail: true,
  devtool: 'source-map',
  entry: [
    require.resolve('react-scripts/config/polyfills'),
    paths.appIndexJs,
  ],
  output: {
    path: paths.appBuild,
    filename: 'kreta.[hash].js',
    publicPath: PUBLIC_PATH
  },
  resolve: {
    fallback: paths.nodePaths,
    extensions: ['.js', '.json', '.jsx', '.css', '.scss', '.svg', '']
  },
  module: {
    preLoaders: [
      {
        test: /\.(js|jsx)$/,
        loader: 'eslint',
        include: paths.appSrc,
      },
      {
        test: /\.(css|scss)$/,
        loader: 'stylelint',
        include: paths.appScss,
      }
    ],
    loaders: [
      {
        exclude: [
          /\.html$/,
          /\.(js|jsx)$/,
          /\.(css|scss)$/,
          /\.json$/,
          /\.svg$/
        ],
        loader: 'url',
        query: {
          limit: 10000,
          name: '[name].[hash:8].[ext]'
        }
      },
      {
        test: /\.(js|jsx)$/,
        include: paths.appSrc,
        loader: 'babel',
        query: {
          cacheDirectory: true
        }
      },
      {
        test: /\.(css|scss)$/,
        loader: ExtractTextPlugin.extract(
          'style', 'css!postcss!sass?outputStyle=expanded&sourceComments=true'
        )
      },
      {
        test: /\.json$/,
        loader: 'json'
      },
      {
        test: /\.svg$/,
        loader: 'svg-sprite?name=[name]_[hash].svg'
      },
    ]
  },
  postcss: () => {
    return [
      autoprefixer({
        browsers: [
          '>1%',
          'last 4 versions',
          'Firefox ESR',
          'not ie < 9', // React doesn't support IE8 anyway
        ]
      }),
    ];
  },
  sassLoader: {
    includePaths: [path.join(__dirname, paths.appScss)]
  },
  plugins: [
    new InterpolateHtmlPlugin({
      PUBLIC_URL: PUBLIC_URL
    }),
    new HtmlWebpackPlugin({
      inject: true,
      template: paths.appHtml,
      minify: {
        removeComments: true,
        collapseWhitespace: true,
        removeRedundantAttributes: true,
        useShortDoctype: true,
        removeEmptyAttributes: true,
        removeStyleLinkTypeAttributes: true,
        keepClosingSlash: true,
        minifyJS: true,
        minifyCSS: true,
        minifyURLs: true
      }
    }),
    new webpack.DefinePlugin(env),
    new webpack.optimize.OccurrenceOrderPlugin(),
    new webpack.optimize.DedupePlugin(),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        screw_ie8: true, // React doesn't support IE8
        warnings: false
      },
      mangle: {
        screw_ie8: true
      },
      output: {
        comments: false,
        screw_ie8: true
      }
    }),
    new webpack.HotModuleReplacementPlugin(),
    new CaseSensitivePathsPlugin(),
    new ExtractTextPlugin('kreta.[contenthash].css'),
    new WatchMissingNodeModulesPlugin(paths.appNodeModules)
  ],
  node: {
    fst: 'empty',
    net: 'empty',
    tls: 'empty'
  }
};
