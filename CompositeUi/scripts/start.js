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

import dotenv from 'dotenv';
dotenv.config({silent: true});

import chalk from 'chalk';
import WebpackDevServer from 'webpack-dev-server';
import detect from 'detect-port';
import clearConsole from 'react-dev-utils/clearConsole';
import checkRequiredFiles from 'react-dev-utils/checkRequiredFiles';
import getProcessForPort from 'react-dev-utils/getProcessForPort';
import openBrowser from 'react-dev-utils/openBrowser';
import prompt from 'react-dev-utils/prompt';

import addWebpackMiddleware from './utils/addWebpackMiddleware';
import config from './../config/webpack.config.babel.dev';
import createWebpackCompiler from './utils/createWebpackCompiler';
import devServerConfig from './../config/webpackDevServer.config';
import paths from './../config/paths';

const isInteractive = process.stdout.isTTY;

if (!checkRequiredFiles([paths.appHtml, paths.appIndexJs])) {
  process.exit(1);
}

const DEFAULT_PORT = parseInt(process.env.PORT, 10) || 3000;

const run = (port) => {
  const protocol = process.env.HTTPS === 'true' ? 'https' : 'http';
  const host = process.env.HOST || 'localhost';

  const compiler = createWebpackCompiler(config, (showInstructions) => {
    if (!showInstructions) {
      return;
    }
    console.log();
    console.log('The app is running at:');
    console.log();
    console.log(`  ${chalk.cyan(`${protocol}://${host}:${port}/`)}`);
    console.log();
    console.log('Note that the development build is not optimized.');
    console.log(`To create a production build, use ${chalk.cyan(`yarn build`)}.`);
    console.log();
  });

  const devServer = new WebpackDevServer(compiler, devServerConfig);

  addWebpackMiddleware(devServer);
  devServer.listen(port, (err) => {
    if (err) {
      return console.log(err);
    }
    if (isInteractive) {
      clearConsole();
    }
    console.log(chalk.cyan('Starting the development server...'));
    console.log();
    if (isInteractive) {
      openBrowser(`${protocol}://${host}:${port}/`);
    }
  });
};

detect(DEFAULT_PORT).then(port => {
  if (port === DEFAULT_PORT) {
    return run(port);
  }

  if (isInteractive) {
    clearConsole();

    const
      existingProcess = getProcessForPort(DEFAULT_PORT),
      question = chalk.yellow(
          `Something is already running on port ${DEFAULT_PORT}.` +
          `${existingProcess ? ` Probably:\n  ${existingProcess}` : ''}`
        ) + '\n\nWould you like to run the app on another port instead?';

    prompt(question, true).then(shouldChangePort => {
      if (shouldChangePort) {
        run(port);
      }
    }).catch(err => console.log(err));

  } else {
    console.log(chalk.red(`Something is already running on port ${DEFAULT_PORT}.`));
  }
}).catch(err => console.log(err));
