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

import dotenv from 'dotenv';
dotenv.config({silent: true});

import _gzipSize from 'gzip-size';
import chalk from 'chalk';
import checkRequiredFiles from 'react-dev-utils/checkRequiredFiles';
import filesize from 'filesize';
import fs from 'fs-extra';
import path from 'path';
import recursive from 'recursive-readdir';
import stripAnsi from 'strip-ansi';
import webpack from 'webpack';

import config from './../config/webpack.config.babel.prod';
import paths from './../config/paths';

const gzipSize = _gzipSize.sync;

if (!checkRequiredFiles([paths.appHtml, paths.appIndexJs])) {
  process.exit(1);
}

const removeFileNameHash = (fileName) => {
  return fileName
    .replace(paths.appBuild, '')
    .replace(/\/?(.*)(\.\w+)(\.js|\.css)/, (match, p1, p2, p3) => p1 + p3);
};

const getDifferenceLabel = (currentSize, previousSize) => {
  const
    FIFTY_KILOBYTES = 1024 * 50,
    difference = currentSize - previousSize,
    fileSize = !Number.isNaN(difference) ? filesize(difference) : 0;

  if (difference >= FIFTY_KILOBYTES) {
    return chalk.red(`+${fileSize}`);
  } else if (difference < FIFTY_KILOBYTES && difference > 0) {
    return chalk.yellow(`+${fileSize}`);
  } else if (difference < 0) {
    return chalk.green(fileSize);
  } else {
    return '';
  }
};

const printFileSizes = (stats, previousSizeMap) => {
  const assets = stats.toJson().assets
    .filter(asset => /\.(js|css)$/.test(asset.name))
    .map(asset => {
      const
        fileContents = fs.readFileSync(`${paths.appBuild}/${asset.name}`),
        size = gzipSize(fileContents),
        previousSize = previousSizeMap[removeFileNameHash(asset.name)],
        difference = getDifferenceLabel(size, previousSize);

      return {
        folder: path.join('build', path.dirname(asset.name)),
        name: path.basename(asset.name),
        size: size,
        sizeLabel: filesize(size) + (difference ? ' (' + difference + ')' : '')
      };
    });
  assets.sort((a, b) => b.size - a.size);
  const longestSizeLabelLength = Math.max.apply(null, assets.map(a => stripAnsi(a.sizeLabel).length));

  assets.forEach(asset => {
    let
      sizeLabel = asset.sizeLabel,
      sizeLength = stripAnsi(sizeLabel).length;

    if (sizeLength < longestSizeLabelLength) {
      sizeLabel += ' '.repeat(longestSizeLabelLength - sizeLength);
    }
    console.log(`  ${sizeLabel}  ${chalk.dim(asset.folder + path.sep) + chalk.cyan(asset.name)}  `);
  });
};

const printErrors = (summary, errors) => {
  console.log(chalk.red(summary));
  console.log();
  errors.forEach(err => {
    console.log(err.message || err);
    console.log();
  });
};

const printResultWithPublicPath = (publicPath) => {
  // homepage = http://kreta.io/whatever-public-path

  console.log(`The project was built assuming it is hosted at ${chalk.green(publicPath)}.`);
  console.log(`You can control this with the ${chalk.green('homepage')} field in your ${chalk.cyan('package.json')}.`);
  console.log();
  console.log(`The ${chalk.cyan('build')} folder is ready to be deployed.`);
  console.log();
};

const printResultWithoutPublicPath = () => {
  // homepage = http://kreta.io
  console.log(`You can control this with the ${chalk.green('homepage')} field in your ${chalk.cyan('package.json')}.`);
};

const printResultWithoutHomepage = () => {
  console.log(`To override this, specify the ${chalk.green('homepage')} in your ${chalk.cyan('package.json')}.`);
  console.log('For example:');
  console.log();
  console.log(`  ${chalk.green('"homepage"')}${chalk.cyan(': ')}${chalk.green('"http://kreta.io"')}${chalk.cyan(',')}`);
};

const build = (previousSizeMap) => {
  console.log('Creating an optimized production build...');

  webpack(config).run((err, stats) => {
    if (err) {
      printErrors('Failed to compile.', [err]);
      process.exit(1);
    }
    if (stats.compilation.errors.length) {
      printErrors('Failed to compile.', stats.compilation.errors);
      process.exit(1);
    }
    if (process.env.CI && stats.compilation.warnings.length) {
      printErrors('Failed to compile.', stats.compilation.warnings);
      process.exit(1);
    }

    console.log(chalk.green('Compiled successfully.'));
    console.log();
    console.log('File sizes after gzip:');
    console.log();
    printFileSizes(stats, previousSizeMap);
    console.log();

    const
      openCommand = process.platform === 'win32' ? 'start' : 'open',
      appPackage = require(paths.appPackageJson),
      homepagePath = appPackage.homepage,
      publicPath = config.output.publicPath;

    if (publicPath !== '/') {
      printResultWithPublicPath(publicPath);
    } else {
      console.log('The project was built assuming it is hosted at the server root.');
      if (homepagePath) {
        printResultWithoutPublicPath();
      } else {
        printResultWithoutHomepage();
      }
      console.log();
      console.log(`The ${chalk.cyan('build')} folder is ready to be deployed.`);
      console.log('You may also serve it locally with a static server:');
      console.log();
      console.log(`  ${chalk.cyan('yarn')} global add pushstate-server`);
      console.log(`  ${chalk.cyan('pushstate-server')} build`);
      console.log(`  ${chalk.cyan(openCommand)} http://localhost:9000`);
      console.log();
    }
  });
};

const copyPublicFolder = () => {
  fs.copySync(paths.appPublic, paths.appBuild, {
    dereference: true,
    filter: file => file !== paths.appHtml
  });
};

recursive(paths.appBuild, (err, fileNames) => {
  const previousSizeMap = (fileNames || [])
    .filter(fileName => /\.(js|css)$/.test(fileName))
    .reduce((memo, fileName) => {
      const contents = fs.readFileSync(fileName);
      const key = removeFileNameHash(fileName);

      memo[key] = gzipSize(contents);

      return memo;
    }, {});

  fs.emptyDirSync(paths.appBuild);
  build(previousSizeMap);
  copyPublicFolder();
});
