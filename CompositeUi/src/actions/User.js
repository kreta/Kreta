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
import Register from './../api/rest/User/Register';
import ResetPassword from './../api/rest/User/ResetPassword';
import Security from './../api/rest/User/Security';

import {routes} from './../Routes';

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
          routeActions.push(routes.home)
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
          routeActions.push(routes.login)
        );
      });
  },
  register: (formData) => (dispatch) => {
    dispatch({
      type: ActionTypes.USER_REGISTERING
    });
    return Register.signUp(formData)
      .then(() => {
        dispatch({
          type: ActionTypes.USER_REGISTERED,
        });
      }, (errorData) => {
        errorData.then(() => {
          dispatch({
            type: ActionTypes.USER_REGISTER_ERROR,
          });
        });
      });
  },
  enable: (confirmationToken) => (dispatch) => {
    dispatch({
      type: ActionTypes.USER_ENABLE
    });
    return Register.enable(confirmationToken)
      .then(() => {
        dispatch({
          type: ActionTypes.USER_ENABLED,
        });
      }, (errorData) => {
        errorData.then(() => {
          dispatch({
            type: ActionTypes.USER_ENABLE_ERROR,
          });
        });
      });
  },
  requestResetPassword: (formData) => (dispatch) => {
    dispatch({
      type: ActionTypes.USER_REQUESTING_RESET_PASSWORD
    });
    return ResetPassword.request(formData.email)
      .then(() => {
        dispatch({
          type: ActionTypes.USER_REQUESTED_RESET_PASSWORD,
        });
      });
  },
  changePassword: (formData) => (dispatch) => {
    dispatch({
      type: ActionTypes.USER_RESETTING_PASSWORD
    });
    return ResetPassword.change(formData.token, formData.passwords)
      .then(() => {
        dispatch({
          type: ActionTypes.USER_RESTORED_PASSWORD,
        });
        dispatch(
          routeActions.push(routes.login)
        );
      }, (errorData) => {
        errorData.then(() => {
          dispatch({
            type: ActionTypes.USER_RESET_PASSWORD_ERROR,
          });
          dispatch(
            routeActions.push(routes.requestResetPassword)
          );
        });
      });
  }
};

export default Actions;
