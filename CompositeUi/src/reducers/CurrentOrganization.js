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
  fetching: true,
  organization: null,
  projects: []
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.CURRENT_ORGANIZATION_FETCHING: {
      return {...state, fetching: true};
    }
    case ActionTypes.CURRENT_ORGANIZATION_RECEIVED: {
      return {...state, fetching: false, organization: action.organization};
    }

    case ActionTypes.PROJECT_CREATING: {
      return {...state, waiting: true};
    }
    case ActionTypes.PROJECT_CREATED: {
      return {...state, tasks: [...state.projects, action.project], waiting: false};
    }
    case ActionTypes.PROJECT_CREATE_ERROR: {
      return {...state, errors: action.errors};
    }

    default: {
      return state;
    }
  }
}
