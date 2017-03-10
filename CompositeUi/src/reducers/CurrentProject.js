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

const
  filters = (assignee) => {
    const assigneeFilters = [{
        filter: 'assignee',
        selected: true,
        title: 'All',
        value: ''
      }, {
        filter: 'assignee',
        selected: false,
        title: 'Assigned to me',
        value: assignee
      }],
      priorityFilters = [{
        filter: 'priority',
        selected: true,
        title: 'All priorities',
        value: ''
      }
      ],
      priorities = [{
        id: 'low',
        name: 'LOW'
      }, {
        id: 'medium',
        name: 'MEDIUM'
      }, {
        id: 'high',
        name: 'HIGH'
      }],
      progressFilters = [{
        filter: 'progress',
        selected: true,
        title: 'All progresses',
        value: ''
      }],
      progresses = [{
        id: 'todo',
        name: 'TODO'
      }, {
        id: 'doing',
        name: 'DOING'
      }, {
        id: 'done',
        name: 'DONE'
      }];

    priorities.forEach((priority) => {
      priorityFilters.push({
        filter: 'priority',
        selected: false,
        title: priority.name,
        value: priority.name
      });
    });

    progresses.forEach((progress) => {
      progressFilters.push({
        filter: 'progress',
        selected: false,
        title: progress.name,
        value: progress.name
      });
    });

    return [assigneeFilters, priorityFilters, progressFilters];
  },
  initialState = {
    errors: [],
    waiting: true,
    filters: [],
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
    case ActionTypes.CURRENT_PROJECT_TASK_FILTERS_LOADED: {
      initialState.filters = filters(action.assignee);

      return {...state, filters: initialState.filters};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_FILTERED: {
      initialState.project._tasks49h6f1 = action.tasks;

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
        const tasks = initialState.project._tasks49h6f1.edges;

        tasks.map((task, index) => {
          if (task.node.numeric_id === parseInt(action.selectedTask, 10)) {
            selectedTaskIndex = index;
          }
        });

        const currentTask = tasks[selectedTaskIndex];
        if (typeof currentTask !== 'undefined') {
          selectedTask = currentTask.node;
        }
      }

      return {...state, selectedTask};
    }
    default: {
      return state;
    }
  }
}
