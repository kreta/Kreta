/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {routeActions} from 'react-router-redux';

import ActionTypes from './../constants/ActionTypes';
import AuthInstance from './../api/Auth';

const Actions = {
  login: (credentialData) => (dispatch) => {
    AuthInstance.login(credentialData.username, credentialData.password);
    dispatch({
      type: ActionTypes.USER_LOGIN,
      token: AuthInstance.token()
    });
    dispatch(
      routeActions.push('/')
    );
  },
  logout: () => (dispatch) => {
    AuthInstance.logout();
    dispatch({
      type: ActionTypes.USER_LOGOUT
    });
    setTimeout(() => {
      dispatch(
        routeActions.push('/login')
      );
    }, 200);
  }
};

export default Actions;
