/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

process.env.NODE_ENV = 'development';

import CaseSensitivePathsPlugin from 'case-sensitive-paths-webpack-plugin';
import HtmlWebpackPlugin from 'html-webpack-plugin';
import InterpolateHtmlPlugin from 'react-dev-utils/InterpolateHtmlPlugin';
import StyleLintPlugin from 'stylelint-webpack-plugin';
import WatchMissingNodeModulesPlugin from 'react-dev-utils/WatchMissingNodeModulesPlugin';

import autoprefixer from 'autoprefixer';
import path from 'path';
import webpack from 'webpack';

import paths from './paths';
import env from './env';

const
  PUBLIC_PATH = '/',
  PUBLIC_URL = '';

export default {
  devtool: 'cheap-module-source-map',
  entry: [
    require.resolve('react-dev-utils/webpackHotDevClient'),
    require.resolve('./polyfills'),
    paths.appIndexJs,
  ],
  output: {
    path: paths.appPublic,
    pathinfo: true,
    filename: 'kreta.js',
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
      use: [
        {
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
        /\.svg$/
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
        name: '[name]_[hash].svg'
      }
    }, {
      test: /\.(js|jsx)$/,
      include: paths.appSrc,
      loader: 'babel-loader',
      options: {
        cacheDirectory: true,
      },
    }, {
      test: /\.(css|scss)$/,
      use: [
        'style-loader', {
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
            ],
          },
        }, {
          loader: 'sass-loader',
          options: {
            includePaths: [
              path.join(__dirname, paths.appScss)
            ]
          }
        }
      ],
    }]
  },
  plugins: [
    new CaseSensitivePathsPlugin(),
    new InterpolateHtmlPlugin({
      PUBLIC_URL: PUBLIC_URL
    }),
    new HtmlWebpackPlugin({
      inject: true,
      template: paths.appHtml,
    }),
    new StyleLintPlugin(),
    new WatchMissingNodeModulesPlugin(paths.appNodeModules),
    new webpack.DefinePlugin(env(PUBLIC_URL)),
    new webpack.HotModuleReplacementPlugin()
  ],
  node: {
    fs: 'empty',
    net: 'empty',
    tls: 'empty',
  },
  performance: {
    hints: false,
  },
};
