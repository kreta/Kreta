/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import CaseSensitivePathsPlugin from 'case-sensitive-paths-webpack-plugin';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import WatchMissingNodeModulesPlugin from 'react-dev-utils/WatchMissingNodeModulesPlugin';

import autoprefixer from 'autoprefixer';
import path from 'path';
import fs from 'fs';
import webpack from 'webpack';

const appDirectory = fs.realpathSync(process.cwd());

const resolveApp = (relativePath) => {
  return path.resolve(appDirectory, relativePath);
};

const nodePaths = (process.env.NODE_PATH || '')
  .split(process.platform === 'win32' ? ';' : ':')
  .filter(Boolean)
  .map(resolveApp);

const paths = {
  appPublic: resolveApp('public'),
  appHtml: resolveApp('public/index.html'),
  appIndexJs: resolveApp('src/Kreta.js'),
  appPackageJson: resolveApp('package.json'),
  appSrc: resolveApp('src'),
  appScss: resolveApp('src/scss'),
  yarnLockFile: resolveApp('yarn.lock'),
  appNodeModules: resolveApp('node_modules'),
  nodePaths: nodePaths
};

const env = () => {
  const REACT_APP = /^REACT_APP_/i;
  const processEnv = Object
    .keys(process.env)
    .filter(key => REACT_APP.test(key))
    .reduce((env, key) => {
      env[key] = JSON.stringify(process.env[key]);

      return env;
    }, {
      'NODE_ENV': JSON.stringify(
        process.env.NODE_ENV || 'development'
      ),
    });

  return {'process.env': processEnv};
};

export default {
  devtool: 'cheap-module-source-map',
  entry: [
    require.resolve('react-dev-utils/webpackHotDevClient'),
    paths.appIndexJs
  ],
  output: {
    path: paths.appPublic,
    pathinfo: true,
    filename: 'app.js',
    publicPath: '/'
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
          /\.json$/
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
      }
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
//     new webpack.BannerPlugin(LICENSE),
    new webpack.DefinePlugin(env),
    new webpack.HotModuleReplacementPlugin(),
    new CaseSensitivePathsPlugin(),
    new ExtractTextPlugin('app.css'),
    new WatchMissingNodeModulesPlugin(paths.appNodeModules)
  ],
  node: {
    fst: 'empty',
    net: 'empty',
    tls: 'empty'
  }
};
