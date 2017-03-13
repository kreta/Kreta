/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

process.env.NODE_ENV = 'production';

import ExtractTextPlugin from 'extract-text-webpack-plugin';
import HtmlWebpackPlugin from 'html-webpack-plugin';
import InterpolateHtmlPlugin from 'react-dev-utils/InterpolateHtmlPlugin';
import ManifestPlugin from 'webpack-manifest-plugin';

import autoprefixer from 'autoprefixer';
import path from 'path';
import stylelint from 'stylelint';
import webpack from 'webpack';

import paths from './paths';
import _env from './env';

const
  PUBLIC_PATH = paths.servedPath,
  PUBLIC_URL = paths.publicUrl;

const env = _env(PUBLIC_URL);

if (env['process.env'].NODE_ENV !== '"production"') {
  throw new Error('Production builds must have NODE_ENV=production.');
}

export default {
  bail: true,
  devtool: 'source-map',
  entry: [
    require.resolve('./polyfills'),
    paths.appIndexJs,
  ],
  output: {
    path: paths.appBuild,
    filename: '[name].[chunkhash:8].js',
    chunkFilename: '[name].[chunkhash:8].chunk.js',
    publicPath: PUBLIC_PATH
  },
  resolve: {
    modules: ['node_modules'].concat(paths.nodePaths),
    extensions: ['.js', '.json', '.jsx', '.css', '.scss', '.svg']
  },
  module: {
    rules: [{
      parser: {
        requireEnsure: false
      }
    }, {
      test: /\.(js|jsx)$/,
      enforce: 'pre',
      use: [{
        loader: 'eslint-loader',
      },
      ],
      include: paths.appSrc,
    }, {
      exclude: [
        /\.html$/,
        /\.(js|jsx)$/,
        /\.(css|scss)$/,
        /\.json$/,
        /\.bmp$/,
        /\.gif$/,
        /\.jpe?g$/,
        /\.png$/,
        /\.svg$/,
      ],
      loader: 'file-loader',
      options: {
        name: '[name].[hash:8].[ext]',
      },
    }, {
      test: [
        /\.bmp$/,
        /\.gif$/,
        /\.jpe?g$/,
        /\.png$/
      ],
      loader: 'url-loader',
      options: {
        limit: 10000,
        name: '[name].[hash:8].[ext]',
      },
    }, {
      test: /\.svg$/,
      loader: 'svg-sprite-loader',
      options: {
        name: '[name].[hash:8].svg'
      }
    }, {
      test: /\.(js|jsx)$/,
      include: paths.appSrc,
      loader: 'babel-loader',
    }, {
      test: /\.(css|scss)$/,
      loader: ExtractTextPlugin.extract({
        fallback: 'style-loader',
        publicPath: PUBLIC_PATH,
        use: [{
          loader: 'css-loader',
          options: {
            importLoaders: 1,
          },
        }, {
          loader: 'postcss-loader',
          options: {
            ident: 'postcss',
            plugins: () => [
              autoprefixer({
                browsers: [
                  '>1%',
                  'last 4 versions',
                  'Firefox ESR',
                  'not ie < 9',
                ],
              }),
              stylelint(),
            ],
          },
        }, {
          loader: 'sass-loader',
          options: {
            includePaths: [
              path.join(__dirname, paths.appScss)
            ]
          }
        }],
      })
    }],
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
        minifyURLs: true,
      },
    }),
    new webpack.DefinePlugin(env),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        screw_ie8: true,
        warnings: false,
      },
      mangle: {
        screw_ie8: true,
      },
      output: {
        comments: false,
        screw_ie8: true,
      },
      sourceMap: true,
    }),
    new ExtractTextPlugin({
      filename: '[name].[contenthash:8].css',
    }),
    new ManifestPlugin({
      fileName: 'asset-manifest.json',
    }),
  ],
  node: {
    fs: 'empty',
    net: 'empty',
    tls: 'empty',
  },
};
