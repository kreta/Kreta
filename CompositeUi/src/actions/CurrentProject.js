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

import {routes} from './../Routes';

import ActionTypes from './../constants/ActionTypes';
import TaskApi from './../api/Task';
import ProjectQueryRequest from './../api/graphql/query/ProjectQueryRequest';
import TasksQueryRequest from './../api/graphql/query/TasksQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';
import UserInjector from './../helpers/UserInjector';

const Actions = {
  fetchProject: (organizationSlug, projectSlug) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_FETCHING
    });
    const query = ProjectQueryRequest.build(organizationSlug, projectSlug);

    TaskManagerGraphQl.query(query, dispatch);
    query.then(data => {
      const project = data.response.project;
      let members = [];

      dispatch({
        type: ActionTypes.CURRENT_PROJECT_RECEIVED,
        project,
      });

      project._tasks4hn9we.edges.map((task) => {
        members = [...members, task.node.assignee, task.node.creator];
      });

      UserInjector.injectUserForId([
        ...project.organization.organization_members,
        ...project.organization.owners,
        ...members
      ]).then(() => (
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_RECEIVED,
          project
        })
      ));
    });
  },
  selectCurrentTask: (task) => (dispatch) => (
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_SELECTED_TASK_CHANGED,
      selectedTask: task
    })
  ),
  loadFilters: (assignee) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_FILTERS_LOADED,
      assignee
    });
  },
  filterTasks: (filters) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_FILTERING
    });
    const query = TasksQueryRequest.build(filters);

    TaskManagerGraphQl.query(query, dispatch);
    query.then(data => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_TASK_FILTERED,
        tasks: data.response.tasks,
      });
    });
  },
  createTask: (taskData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_CREATING
    });
    TaskApi.postTask(taskData)
      .then((task) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_CREATED,
          task
        });
        dispatch(
          routeActions.push(routes.task.show(task.project.organization.slug, task.project.slug, task.id))
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
