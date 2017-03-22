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
      }],
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
      return {...state, project: action.project, waiting: false};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_FILTERS_LOADED: {
      return {...state, filters: filters(action.assignee)};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_FILTERED: {
      return {...state, project: {...state.project, _tasks49h6f1: action.tasks}};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_CREATING: {
      return {...state, errors: [], updating: true};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_CREATED: {
      return {
        ...state, project: {
          ...state.project, _tasks49h6f1: {
            ...state.project._tasks49h6f1, edges: [
              ...state.project._tasks49h6f1.edges,
              {node: action.task, cursor: 'YXJyYXljb25uZWN0aW9uOjE5'}
            ]
          }
        },
        updating: false
      };
    }
    case ActionTypes.CURRENT_PROJECT_TASK_CREATE_ERROR: {
      return {...state, errors: action.errors, updating: false};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_UPDATING: {
      return {...state, errors: [], updating: true};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_UPDATED: {
      const index = state.project._tasks49h6f1.edges.findIndex(edge => (edge.node.id === action.task.id));

      return {
        ...state, project: {
          ...state.project, _tasks49h6f1: {
            ...state.project._tasks49h6f1, edges: [
              ...state.project._tasks49h6f1.edges.slice(0, index),
              {node: action.task, cursor: 'YXJyYXljb25uZWN0aW9uOjE5'},
              ...state.project._tasks49h6f1.edges.slice(index + 1)
            ]
          }
        },
        updating: false
      };
    }
    case ActionTypes.CURRENT_PROJECT_TASK_UPDATE_ERROR: {
      return {...state, errors: action.errors, updating: false};
    }
    case ActionTypes.CURRENT_PROJECT_TASK_UPDATED_PROGRESS: {
      const index = state.project._tasks49h6f1.edges.findIndex(edge => (edge.node.id === action.task.id)),
        task = {...state.project._tasks49h6f1.edges[index].node, progress: action.task.progress};

      return {
        ...state, project: {
          ...state.project, _tasks49h6f1: {
            ...state.project._tasks49h6f1, edges: [
              ...state.project._tasks49h6f1.edges.slice(0, index),
              {
                node: task,
                cursor: 'YXJyYXljb25uZWN0aW9uOjE5'
              },
              ...state.project._tasks49h6f1.edges.slice(index + 1)
            ]
          }
        }, selectedTask: state.selectedTask.id === task.id ? task : state.selectedTask
      };
    }
    case ActionTypes.CURRENT_PROJECT_SELECTED_TASK_CHANGED: {
      let
        selectedTaskIndex = 0,
        selectedTask = null;

      if (null !== state.project) {
        const tasks = state.project._tasks49h6f1.edges;

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
