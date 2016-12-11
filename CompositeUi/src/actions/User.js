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
import Security from '../api/rest/User/Security';

const Actions = {
  login: (credentialData) => (dispatch) => {
    dispatch({
      type: ActionTypes.USER_AUTHORIZING
    });
    return Security.login(credentialData.email, credentialData.password)
      .then((json) => {
        localStorage.token = json.token;
        dispatch({
          type: ActionTypes.USER_AUTHORIZED,
          token: json.token
        });
        dispatch(
          routeActions.push('/')
        );
      }, (errorData) => {
        errorData.then((errors) => {
          dispatch({
            type: ActionTypes.USER_AUTHORIZATION_ERROR,
            errors
          });
        });
      });
  },
  logout: () => (dispatch) => {
    dispatch({
      type: ActionTypes.USER_UNAUTHORIZING
    });
    return Security.logout()
      .then(() => {
        dispatch({
          type: ActionTypes.USER_UNAUTHORIZED
        });
        dispatch(
          routeActions.push('/login')
        );
      });
  }
};

export default Actions;
