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
  tasks: [],
  project: null,
  selectedTask: null
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
    case ActionTypes.CURRENT_PROJECT_TASK_FILTERED: {
      initialState.project._tasks4hn9we = action.tasks;

      return {...state};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_CREATING: {
      return {...state, errors: []};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_CREATED: {
      return {...state, tasks: [...state.tasks, action.task]};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_CREATE_ERROR: {
      return {...state, errors: action.errors};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_UPDATE: {
      return {...state, errors: []};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_UPDATED: {
      const index = state.tasks.findIndex(task => task.id === action.task.id);

      return {
        ...state, tasks: [
          ...state.tasks.slice(0, index),
          action.task,
          ...state.tasks.slice(index + 1)
        ]
      };
    }
    case ActionTypes.CURRENT_PROJECT_TASK_UPDATE_ERROR: {
      return {...state, errors: action.errors};
    }
    case ActionTypes.CURRENT_PROJECT_SELECTED_TASK_CHANGED: {
      let
        selectedTaskIndex = 0,
        selectedTask = null;

      if (null !== initialState.project) {
        initialState.project._tasks4hn9we.edges.map((task, index) => {
          if (task.node.id === action.selectedTask) {
            selectedTaskIndex = index;
          }
        });

        selectedTask = initialState.project._tasks4hn9we.edges[selectedTaskIndex].node;
      }

      return {...state, selectedTask};
    }
    default: {
      return state;
    }
  }
}
