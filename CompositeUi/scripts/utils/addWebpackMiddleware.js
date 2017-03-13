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

import historyApiFallback from 'connect-history-api-fallback';

const addWebpackMiddleware = (devServer) => {
  devServer.use(
    historyApiFallback({
      disableDotRule: true,
      htmlAcceptHeaders: ['text/html', '*/*'],
    })
  );

  devServer.use(devServer.middleware);
};

export default addWebpackMiddleware;
