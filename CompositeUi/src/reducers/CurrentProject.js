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
  fetchingIssues: true,
  fetchingProjects: true,
  filters: [],
  issues: [],
  project: null,
  selectedIssue: null
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.CURRENT_PROJECT_FETCHING: {
      return {...state, fetchingProjects: true, fetchingIssues: true};
    }
    case ActionTypes.CURRENT_PROJECT_RECEIVED: {
      return {...state, project: action.project, fetchingProjects: false};
    }
    case ActionTypes.CURRENT_PROJECT_ISSUES_RECEIVED: {
      return {...state, issues: action.issues, fetchingIssues: false};
    }
    case ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_FETCHING: {
      return {...state, selectedIssue: null};
    }
    case ActionTypes.CURRENT_PROJECT_ISSUE_CREATING: {
      return {...state, errors: []};
    }
    case ActionTypes.CURRENT_PROJECT_ISSUE_CREATED: {
      return {...state, issues: [...state.issues, action.issue]};
    }
    case ActionTypes.CURRENT_PROJECT_ISSUE_CREATE_ERROR: {
      return {...state, errors: action.errors};
    }
    case ActionTypes.CURRENT_PROJECT_ISSUE_UPDATE: {
      return {...state, errors: []};
    }
    case ActionTypes.CURRENT_PROJECT_ISSUE_UPDATED: {
      const index = state.issues.findIndex(issue => issue.id === action.issue.id);

      return {
        ...state, issues: [
          ...state.issues.slice(0, index),
          action.issue,
          ...state.issues.slice(index + 1)
        ]
      };
    }
    case ActionTypes.CURRENT_PROJECT_ISSUE_UPDATE_ERROR: {
      return {...state, errors: action.errors};
    }
    case ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_CHANGED: {
      return {...state, selectedIssue: action.selectedIssue};
    }
    default: {
      return state;
    }
  }
}
