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

export default (publicUrl) => {
  const processEnv = {
    'TASK_MANAGER_HOST': JSON.stringify(
      process.env.TASK_MANAGER_HOST || '//taskmanager.localhost'
    ),
    'IDENTITY_ACCESS_HOST': JSON.stringify(
      process.env.IDENTITY_ACCESS_HOST || '//identityaccess.localhost'
    ),
    'NODE_ENV': JSON.stringify(
      process.env.NODE_ENV || 'development'
    ),
    'PUBLIC_URL': JSON.stringify(
      publicUrl
    )
  };

  return {
    'process.env': processEnv,
    '__DEV__': process.env.NODE_ENV === 'development'
  };
};
