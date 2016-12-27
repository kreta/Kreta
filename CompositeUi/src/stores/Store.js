/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {createStore, applyMiddleware, compose} from 'redux';
import createLogger from 'redux-logger';
import thunkMiddleware from 'redux-thunk';
import {syncHistory} from 'react-router-redux';
import reducers from './../Reducers';
import UserActions from './../actions/User';

const
  loggerMiddleware = createLogger({
    level: 'info',
    collapsed: true
  }),
  authInterceptorMiddleware = ({dispatch}) => next => action => {
    if (action.status !== 401) {
      return next(action);
    }
    Promise.resolve(
      dispatch(UserActions.logout())
        .then(() => (
          next(action)
        ))
    );
  };

export default function configureStore(browserHistory) {
  const
    reduxRouterMiddleware = syncHistory(browserHistory),
    createStoreWithMiddleware = compose(
      applyMiddleware(
        reduxRouterMiddleware,
        thunkMiddleware,
        loggerMiddleware,
        authInterceptorMiddleware
      ),
      window.devToolsExtension ? window.devToolsExtension() : f => f
    )(createStore);

  return createStoreWithMiddleware(reducers);
}
