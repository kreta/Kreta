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
  projects: [],
  selectedRow: 0
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.PROJECTS_FETCHING:
      return { ...state, fetching: true };

    case ActionTypes.PROJECTS_RECEIVED:
      return {...state, projects: action.projects, fetching: false};

    case ActionTypes.PROJECTS_FETCH_ERROR:
      return {...state, error: true};

    case ActionTypes.PROJECTS_CREATED:
      return {...state, projects: [...state.projects, action.project]};

    case ActionTypes.PROJECTS_CREATE_ERROR:
      return {...state, errors: action.errors};

    case ActionTypes.PROJECTS_UPDATED:
      const index = state.projects.findIndex((project) => {
        return project.id === action.project.id;
      });
      return {
        ...state, projects: [
          ...state.projects.slice(0, index),
          action.projects,
          ...state.projects.slice(index + 1)
        ],
        selectedIssue: action.issue
      };

    default:
      return state;
  }
}
