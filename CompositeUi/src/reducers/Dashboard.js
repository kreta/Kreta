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
  fetching: true,
  organizations: [],
  projects: []
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.DASHBOARD_DATA_FETCHING:
      return {...state, fetching: true};

    case ActionTypes.DASHBOARD_DATA_RECEIVED:
      return {...state, organizations: action.organizations, projects: action.projects, fetching: false};

    case ActionTypes.DASHBOARD_DATA_FETCH_ERROR:
      return {...state, error: true};

    default:
      return state;
  }
}
