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

import dotenv from 'dotenv';
dotenv.config({silent: true});

import chalk from 'chalk';
import checkRequiredFiles from 'react-dev-utils/checkRequiredFiles';
import FileSizeReporter from 'react-dev-utils/FileSizeReporter';
import fs from 'fs-extra';
import path from 'path';
import webpack from 'webpack';

import config from './../config/webpack.config.babel.prod';
import paths from './../config/paths';

if (!checkRequiredFiles([paths.appHtml, paths.appIndexJs])) {
  process.exit(1);
}

const
  measureFileSizesBeforeBuild = FileSizeReporter.measureFileSizesBeforeBuild,
  printFileSizesAfterBuild = FileSizeReporter.printFileSizesAfterBuild;

measureFileSizesBeforeBuild(paths.appBuild).then(previousFileSizes => {
  fs.emptyDirSync(paths.appBuild);
  build(previousFileSizes);
  copyPublicFolder();
});

const printErrors = (summary, errors) => {
  console.log(chalk.red(summary));
  console.log();
  errors.forEach(err => {
    console.log(err.message || err);
    console.log();
  });
};

const build = (previousFileSizes) => {
  let compiler;

  console.log('Creating an optimized production build...');
  try {
    compiler = webpack(config);
  } catch (err) {
    printErrors('Failed to compile.', [err]);
    process.exit(1);
  }

  compiler.run((err, stats) => {
    if (err) {
      printErrors('Failed to compile.', [err]);
      process.exit(1);
    }
    if (stats.compilation.errors.length) {
      printErrors('Failed to compile.', stats.compilation.errors);
      process.exit(1);
    }
    if (process.env.CI && stats.compilation.warnings.length) {
      printErrors(
        'Failed to compile. When process.env.CI = true, warnings are ' +
        'treated as failures. Most CI servers set this automatically.',
        stats.compilation.warnings
      );
      process.exit(1);
    }
    console.log(chalk.green('Compiled successfully.'));
    console.log();
    console.log('File sizes after gzip:');
    console.log();
    printFileSizesAfterBuild(stats, previousFileSizes);
    console.log();

    const
      publicUrl = paths.publicUrl,
      build = path.relative(process.cwd(), paths.appBuild);

    if (publicUrl) {
      console.log(`The project was built assuming it is hosted at ${chalk.green(publicUrl)}.`);
      console.log(`You can control this with the ${chalk.green('homepage')} field in your ${chalk.cyan('package.json')}.`);
      console.log();
    } else {
      console.log('The project was built assuming it is hosted at the server root.');
      console.log(`To override this, specify the ${chalk.green('homepage')} in your ${chalk.cyan('package.json')}.`);
      console.log('For example, add this to build it for GitHub Pages:');
      console.log();
      console.log(`  ${chalk.green('"homepage"')} ${chalk.cyan(':')} ${chalk.green('"http://myname.github.io/myapp"')}${chalk.cyan(',')}`);
      console.log();
    }
    console.log(`The ${chalk.cyan(build)} folder is ready to be deployed.`);
    console.log('You may serve it with a static server:');
    console.log();
    console.log(`  ${chalk.cyan('yarn')} global add serve`);
    console.log(`  ${chalk.cyan('serve')} -s build`);
    console.log();
  });
};

const copyPublicFolder = () => {
  fs.copySync(paths.appPublic, paths.appBuild, {
    dereference: true,
    filter: file => file !== paths.appHtml,
  });
};
