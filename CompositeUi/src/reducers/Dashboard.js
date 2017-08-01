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
  errors: false,
  fetching: true,
  assignedTasks: [],
  lastUpdatedProjects: [],
  myOrganizations: [],
  searchQuery: ''
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.DASHBOARD_DATA_FETCHING:
      return {...state, fetching: true};

    case ActionTypes.DASHBOARD_DATA_RECEIVED: {
      return {
        ...state,
        fetching: false,
//         assignedTasks: action.tasks,
//         lastUpdatedProjects: action.projects,
        myOrganizations: action.organizations.map(organization => organization.node),
        searchQuery: action.query
      };
    }
    case ActionTypes.DASHBOARD_DATA_FETCH_ERROR:
      return {...state, error: true};

    default:
      return state;
  }
}
