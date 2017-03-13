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

import chalk from 'chalk';
import webpack from 'webpack';
import clearConsole from 'react-dev-utils/clearConsole';
import formatWebpackMessages from 'react-dev-utils/formatWebpackMessages';

const isInteractive = process.stdout.isTTY;
let handleCompile;

const isSmokeTest = process.argv.some(arg => arg.indexOf('--smoke-test') > -1);
if (isSmokeTest) {
  handleCompile = (err, stats) => {
    if (err || stats.hasErrors() || stats.hasWarnings()) {
      process.exit(1);
    } else {
      process.exit(0);
    }
  };
}

const createWebpackCompiler = (config, onReadyCallback) => {
  let compiler;

  try {
    compiler = webpack(config, handleCompile);
  } catch (err) {
    console.log(chalk.red('Failed to compile.'));
    console.log();
    console.log(err.message || err);
    console.log();
    process.exit(1);
  }

  compiler.plugin('invalid', () => {
    if (isInteractive) {
      clearConsole();
    }
    console.log('Compiling...');
  });

  let isFirstCompile = true;
  compiler.plugin('done', stats => {
    if (isInteractive) {
      clearConsole();
    }

    const
      messages = formatWebpackMessages(stats.toJson({}, true)),
      isSuccessful = !messages.errors.length && !messages.warnings.length,
      showInstructions = isSuccessful && (isInteractive || isFirstCompile);

    if (isSuccessful) {
      console.log(chalk.green('Compiled successfully!'));
    }

    if (typeof onReadyCallback === 'function') {
      onReadyCallback(showInstructions);
    }
    isFirstCompile = false;

    if (messages.errors.length) {
      console.log(chalk.red('Failed to compile.'));
      console.log();
      return messages.errors.forEach(message => {
        console.log(message);
        console.log();
      });
    }
    if (messages.warnings.length) {
      console.log(chalk.yellow('Compiled with warnings.'));
      console.log();
      messages.warnings.forEach(message => {
        console.log(message);
        console.log();
      });
      console.log('You may use special comments to disable some warnings.');
      console.log(`Use ${chalk.yellow('// eslint-disable-next-line')} to ignore the next line.`);
      console.log(`Use ${chalk.yellow('/* eslint-disable */')} to ignore all warnings in a file.`);
    }
  });

  return compiler;
};

export default createWebpackCompiler;
