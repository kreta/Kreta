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

import path from 'path';
import fs from 'fs';
import url from 'url';

const
  envPublicUrl = process.env.PUBLIC_URL,
  appDirectory = fs.realpathSync(process.cwd());

const resolveApp = (relativePath) => {
  return path.resolve(appDirectory, relativePath);
};

const nodePaths = (process.env.NODE_PATH || '')
  .split(process.platform === 'win32' ? ';' : ':')
  .filter(Boolean)
  .map(resolveApp);

const ensureSlash = (path, needsSlash) => {
  const hasSlash = path.endsWith('/');

  if (hasSlash && !needsSlash) {
    return path.substr(path, path.length - 1);
  } else if (!hasSlash && needsSlash) {
    return `${path}/`;
  }

  return path;
};

const getPublicUrl = (appPackageJson) => {
  return envPublicUrl || require(appPackageJson).homepage;
};

const getServedPath = (appPackageJson) => {
  const
    publicUrl = getPublicUrl(appPackageJson),
    servedUrl = envPublicUrl || (
        publicUrl ? url.parse(publicUrl).pathname : '/'
      );

  return ensureSlash(servedUrl, true);
};

export default {
  appBuild: resolveApp('build'),
  appPublic: resolveApp('public'),
  appHtml: resolveApp('public/index.html'),
  appIndexJs: resolveApp('src/Kreta.js'),
  appPackageJson: resolveApp('package.json'),
  appSrc: resolveApp('src'),
  appScss: resolveApp('src/scss'),
  appNodeModules: resolveApp('node_modules'),
  nodePaths: nodePaths,
  publicUrl: getPublicUrl(resolveApp('package.json')),
  servedPath: getServedPath(resolveApp('package.json'))
};
