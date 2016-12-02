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
  isLoggedIn: false
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.USER_LOGIN:
      return {...state, token: action.token, isLoggedIn: true};
    case ActionTypes.USER_LOGOUT:
      return {...state, token: null, isLoggedIn: false};
  }
}
