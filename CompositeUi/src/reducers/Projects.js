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
  waiting: true,
  projects: []
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.PROJECTS_FETCHING: {
      return {...state, waiting: true};
    }
    case ActionTypes.PROJECTS_RECEIVED: {
      return {...state, projects: action.projects, waiting: false};
    }
    case ActionTypes.PROJECTS_FETCH_ERROR: {
      return {...state, error: true};
    }

    case ActionTypes.PROJECT_CREATING: {
      return {...state, waiting: true};
    }
    case ActionTypes.PROJECT_CREATED: {
      return {...state, projects: [...state.projects, action.project], waiting: false};
    }
    case ActionTypes.PROJECT_CREATE_ERROR: {
      return {...state, errors: action.errors};
    }

    default:
      return state;
  }
}
