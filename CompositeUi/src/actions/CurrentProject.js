/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {routeActions} from 'react-router-redux';

import ActionTypes from './../constants/ActionTypes';
import TaskApi from './../api/Task';
import ProjectQueryRequest from './../api/graphql/query/ProjectQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';

const Actions = {
  fetchProject: (projectId) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_FETCHING
    });
    const query = ProjectQueryRequest.build(projectId);

    TaskManagerGraphQl.query(query);
    query.then(data => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_RECEIVED,
        project: data.response.project,
      });
    });
  },
  selectCurrentTask: (task) => (
    {
      type: ActionTypes.CURRENT_PROJECT_SELECTED_TASK_CHANGED,
      selectedTask: task
    }
  ),
  createTask: (taskData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_CREATING
    });
    TaskApi.postTask(taskData)
      .then((response) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_CREATED,
          status: response.status,
          task: response.data
        });
        dispatch(
          routeActions.push(`/project/${response.data.project}/task/${response.data.id}`)
        );
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_TASK_CREATE_ERROR,
            status: response.status,
            errors
          });
        });
      });
  },
  updateTask: (taskData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_UPDATE
    });
    TaskApi.putTask(taskData.id, taskData)
      .then((response) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_UPDATED,
          status: response.status,
          task: response.data
        });
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_TASK_UPDATE_ERROR,
            status: response.status,
            errors
          });
        });
      });
  },
  filterTasks: (filter) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_FILTERING
    });
    TaskApi.getTasks(filter)
      .then((response) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_FILTERED,
          filter: response.data,
          status: response.status
        });
      });
  },
  addParticipant: (user) => (dispatch) => {
    const participant = {
      role: 'ROLE_PARTICIPANT',
      user
    };

    setTimeout(() => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_PARTICIPANT_ADDED,
        participant
      });
    });
  }
};

export default Actions;
