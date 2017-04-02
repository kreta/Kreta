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

import {routes} from './../Routes';

import ActionTypes from './../constants/ActionTypes';

import NotificationActions from './../actions/Notification';

import Register from './../api/rest/User/Register';
import ResetPassword from './../api/rest/User/ResetPassword';
import Security from './../api/rest/User/Security';

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
        dispatch(NotificationActions.addNotification(
          'Registration process has been successfully done. Check your email inbox to enable the account',
          'success')
        );
      }, (errorData) => {
        errorData.then(() => {
          dispatch({
            type: ActionTypes.USER_REGISTER_ERROR,
          });
          dispatch(NotificationActions.addNotification(
            'The email is already in use',
            'error'
          ));
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
        dispatch(NotificationActions.addNotification(
          'Your user has been enabled successfully',
          'success')
        );
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
        dispatch(NotificationActions.addNotification(
          'Your password has been reset. Check your email to change your password.',
          'success')
        );
      }, (errorData) => {
        errorData.then(() => {
          dispatch({
            type: ActionTypes.USER_REQUEST_RESET_PASSWORD_ERROR,
          });
          dispatch(NotificationActions.addNotification('Something goes wrong, please try the request again', 'error'));
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
        dispatch(NotificationActions.addNotification(
          'Your password has been changed.',
          'success')
        );
      }, (errorData) => {
        errorData.then(() => {
          dispatch({
            type: ActionTypes.USER_RESET_PASSWORD_ERROR,
          });
          dispatch(
            routeActions.push(routes.requestResetPassword)
          );
          dispatch(NotificationActions.addNotification('Error while changing password', 'error'));
        });
      });
  }
};

export default Actions;
