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
  selectedIssue: null,
  workflow: null
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.CURRENT_PROJECT_FETCHING:
      return {...state, fetchingProjects: true, fetchingIssues: true};

    case ActionTypes.CURRENT_PROJECT_RECEIVED:
      return {...state, project: action.project, filters: action.filters, fetchingProjects: false};

    case ActionTypes.CURRENT_PROJECT_ISSUES_RECEIVED:
      return {...state, issues: action.issues, fetchingIssues: false};

    case ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_FETCHING:
      return {...state, selectedIssue: null};

    case ActionTypes.CURRENT_PROJECT_ISSUE_CREATING:
      return {...state, errors: []};

    case ActionTypes.CURRENT_PROJECT_ISSUE_CREATED:
      return {...state, issues: [...state.issues, action.issue]};

    case ActionTypes.CURRENT_PROJECT_ISSUE_CREATE_ERROR:
      return {...state, errors: action.errors};

    case ActionTypes.CURRENT_PROJECT_ISSUE_UPDATE:
    case ActionTypes.CURRENT_PROJECT_ISSUE_TRANSITION:
      return {...state, errors: []};

    case ActionTypes.CURRENT_PROJECT_ISSUE_UPDATED:
    case ActionTypes.CURRENT_PROJECT_ISSUE_TRANSITIONED:
      const index = state.issues.findIndex((issue) => {
        return issue.id === action.issue.id;
      });
      return {
        ...state, issues: [
          ...state.issues.slice(0, index),
          action.issue,
          ...state.issues.slice(index + 1)
        ],
        selectedIssue: action.issue
      };

    case ActionTypes.CURRENT_PROJECT_ISSUE_UPDATE_ERROR:
      return {...state, errors: action.errors};

    case ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_CHANGED:
      return {...state, selectedIssue: action.selectedIssue};

    case ActionTypes.CURRENT_PROJECT_ISSUE_FILTERING:
      return {...state, issues: [], filters: action.filters, fetchingIssues: true};

    case ActionTypes.CURRENT_PROJECT_ISSUE_FILTERED:
      return {...state, issues: action.issues, fetchingIssues: false};

    case ActionTypes.CURRENT_PROJECT_WORKFLOW_FETCHING:
      return {...state, workflow: null};

    case ActionTypes.CURRENT_PROJECT_WORKFLOW_RECEIVED:
      return {...state, workflow: action.workflow};

    case ActionTypes.PROJECTS_UPDATED:
      if (action.project.id === state.project.id) {
        return {...state, project: action.project}
      }

      return state;

    default:
      return state;
  }
}
