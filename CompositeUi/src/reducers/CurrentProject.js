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
  filters: [],
  issues: [],
  project: null,
  selectedIssue: null
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.CURRENT_PROJECT_FETCHING: {
      return {...state, waiting: true};
    }
    case ActionTypes.CURRENT_PROJECT_RECEIVED: {
      initialState.project = action.project;
      return {...state, project: action.project, waiting: false};
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
      let selectedTaskIndex = 0;

      initialState.project._tasks4hn9we.edges.map((task, index) => {
        if (task.node.id === action.selectedIssue) {
          selectedTaskIndex = index;
        }
      });

      return {...state, selectedIssue: initialState.project._tasks4hn9we.edges[selectedTaskIndex].node};
    }
    default: {
      return state;
    }
  }
}
