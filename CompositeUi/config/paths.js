/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import path from 'path';
import fs from 'fs';

const appDirectory = fs.realpathSync(process.cwd());

const resolveApp = (relativePath) => {
  return path.resolve(appDirectory, relativePath);
};

const nodePaths = (process.env.NODE_PATH || '')
  .split(process.platform === 'win32' ? ';' : ':')
  .filter(Boolean)
  .map(resolveApp);

export default {
  appPublic: resolveApp('public'),
  appHtml: resolveApp('public/index.html'),
  appIndexJs: resolveApp('src/Kreta.js'),
  appPackageJson: resolveApp('package.json'),
  appSrc: resolveApp('src'),
  appScss: resolveApp('src/scss'),
  appNodeModules: resolveApp('node_modules'),
  appPublicPath: '/',
  nodePaths: nodePaths
};
