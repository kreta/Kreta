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

import ExtractTextPlugin from 'extract-text-webpack-plugin';
import HtmlWebpackPlugin from 'html-webpack-plugin';
import InterpolateHtmlPlugin from 'react-dev-utils/InterpolateHtmlPlugin';
import ManifestPlugin from 'webpack-manifest-plugin';
import ModuleScopePlugin from 'react-dev-utils/ModuleScopePlugin';
import SWPrecacheWebpackPlugin from 'sw-precache-webpack-plugin';

import autoprefixer from 'autoprefixer';
import path from 'path';
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
    publicPath: PUBLIC_PATH,
    devtoolModuleFilenameTemplate: info =>
      path
        .relative(paths.appSrc, info.absoluteResourcePath)
        .replace(/\\/g, '/'),
  },
  resolve: {
    modules: ['node_modules'].concat(paths.nodePaths),
    extensions: ['.js', '.json', '.jsx', '.css', '.scss', '.svg'],
    plugins: [
      new ModuleScopePlugin(paths.appSrc, [paths.appPackageJson]),
    ]
  },
  module: {
    strictExportPresence: true,
    rules: [{
      oneOf: [{
        test: [/\.bmp$/, /\.gif$/, /\.jpe?g$/, /\.png$/],
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
        options: {
          compact: true
        }
      }, {
        test: /\.(css|scss)$/,
        loader: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          publicPath: PUBLIC_PATH,
          use: [{
            loader: 'css-loader',
            options: {
              importLoaders: 1,
              minimize: true,
              sourceMap: true,
            },
          }, {
            loader: 'postcss-loader',
            options: {
              ident: 'postcss',
              plugins: () => [
                require('postcss-flexbugs-fixes'),
                autoprefixer({
                  browsers: [
                    '>1%',
                    'last 4 versions',
                    'Firefox ESR',
                    'not ie < 9',
                  ],
                  flexbox: 'no-2009',
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
          }],
        })
      }, {
        loader: 'file-loader',
        exclude: [/\.js$/, /\.html$/, /\.json$/],
        options: {
          name: '[name].[hash:8].[ext]',
        },
      }]
    }]
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
        warnings: false,
        comparisons: false,
      },
      output: {
        comments: false,
        ascii_only: true,
      },
      sourceMap: true,
    }),
    new ExtractTextPlugin({
      filename: '[name].[contenthash:8].css',
    }),
    new ManifestPlugin({
      fileName: 'asset-manifest.json',
    }),
    new SWPrecacheWebpackPlugin({
      dontCacheBustUrlsMatching: /\.\w{8}\./,
      filename: 'service-worker.js',
      logger(message) {
        if (message.indexOf('Total precache size is') === 0) {
          return;
        }
        if (message.indexOf('Skipping static resource') === 0) {
          return;
        }
        console.log(message);
      },
      minify: true,
      navigateFallback: `${PUBLIC_URL}/index.html`,
      navigateFallbackWhitelist: [/^(?!\/__).*/],
      staticFileGlobsIgnorePatterns: [/\.map$/, /asset-manifest\.json$/],
    }),
  ],
  node: {
    dgram: 'empty',
    fs: 'empty',
    net: 'empty',
    tls: 'empty',
  },
};
