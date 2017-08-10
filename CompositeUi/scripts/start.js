/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

process.env.BABEL_ENV = 'development';
process.env.NODE_ENV = 'development';

process.on('unhandledRejection', error => {
  throw error;
});

import dotenv from 'dotenv';
dotenv.config({silent: true});

import chalk from 'chalk';
import checkRequiredFiles from 'react-dev-utils/checkRequiredFiles';
import {choosePort, createCompiler, prepareProxy, prepareUrls} from 'react-dev-utils/WebpackDevServerUtils';
import clearConsole from 'react-dev-utils/clearConsole';
import openBrowser from 'react-dev-utils/openBrowser';
import WebpackDevServer from 'webpack-dev-server';
import webpack from 'webpack';

import createDevServerConfig from './../config/webpackDevServer.config';
import config from './../config/webpack.config.babel.dev';
import paths from './../config/paths';

const isInteractive = process.stdout.isTTY;

if (!checkRequiredFiles([paths.appHtml, paths.appIndexJs])) {
  process.exit(1);
}

const DEFAULT_PORT = parseInt(process.env.PORT, 10) || 3000;
const HOST = process.env.HOST || '0.0.0.0';

choosePort(HOST, DEFAULT_PORT).then(port => {
  if (!port) {
    return;
  }
  const protocol = process.env.HTTPS === 'true' ? 'https' : 'http';
  const appName = require(paths.appPackageJson).name;
  const urls = prepareUrls(protocol, HOST, port);
  const compiler = createCompiler(webpack, config, appName, urls, true);
  const proxySetting = require(paths.appPackageJson).proxy;
  const proxyConfig = prepareProxy(proxySetting, paths.appPublic);
  const serverConfig = createDevServerConfig(
    proxyConfig,
    urls.lanUrlForConfig
  );
  const devServer = new WebpackDevServer(compiler, serverConfig);

  devServer.listen(port, HOST, error => {
    if (error) {
      return console.log(error);
    }
    if (isInteractive) {
      clearConsole();
    }
    console.log(chalk.cyan('Starting the development server...\n'));
    openBrowser(urls.localUrlForBrowser);
  });

  ['SIGINT', 'SIGTERM'].forEach((sig) => {
    process.on(sig, () => {
      devServer.close();
      process.exit();
    });
  });
}).catch(error => {
  if (error && error.message) {
    console.log(error.message);
  }
  process.exit(1);
});
