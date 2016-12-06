/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from './../constants/ActionTypes';

const initialState = {
  errors: [],
  token: null,
  updatingAuthorization: false
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.USER_AUTHORIZING:
      return {...state, updatingAuthorization: true};

    case ActionTypes.USER_AUTHORIZED:
      return {...state, token: action.token, updatingAuthorization: false};

    case ActionTypes.USER_UNAUTHORIZING:
      return {...state, token: action.token, updatingAuthorization: true};

    case ActionTypes.USER_UNAUTHORIZED:
      return {...state, token: null, updatingAuthorization: false};

    case ActionTypes.USER_AUTHORIZATION_ERROR:
      return {...state, token: null, updatingAuthorization: false};

    default:
      return state;
  }
}
