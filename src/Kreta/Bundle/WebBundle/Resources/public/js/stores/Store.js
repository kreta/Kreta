/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import { createStore, applyMiddleware } from 'redux';
import createLogger from 'redux-logger';
import thunkMiddleware from 'redux-thunk';
import { syncHistory } from 'react-router-redux';
import reducers from '../Reducers';

const loggerMiddleware = createLogger({
  level: 'info',
  collapsed: true
});

export default function configureStore(browserHistory) {
  const reduxRouterMiddleware = syncHistory(browserHistory),
    createStoreWithMiddleware = applyMiddleware(
      reduxRouterMiddleware,
      thunkMiddleware,
      loggerMiddleware
  )(createStore);

  return createStoreWithMiddleware(reducers);
}

