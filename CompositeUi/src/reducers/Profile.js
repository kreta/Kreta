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
  fetching: false,
  profile: null
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.PROFILE_FETCHING: {
      return {...state, fetching: true};
    }

    case ActionTypes.PROFILE_RECEIVED: {
      return {...state, profile: action.profile, fetching: false};
    }

    case ActionTypes.PROFILE_UPDATED: {
      return {...state, profile: action.profile};
    }

    case ActionTypes.PROFILE_FETCH_ERROR: {
      return {...state, errors: action.errors};
    }

    case ActionTypes.PROFILE_UPDATE_ERROR: {
      return {...state, errors: action.errors};
    }

    default:
      return state;
  }
}
