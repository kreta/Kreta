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
import NotificationActions from './../actions/Notification';
import ChangeTaskProgressMutationRequest from './../api/graphql/mutation/ChangeTaskProgressMutationRequest';
import CreateTaskMutationRequest from './../api/graphql/mutation/CreateTaskMutationRequest';
import EditTaskkMutationRequest from './../api/graphql/mutation/EditTaskMutationRequest';
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

      project._tasks49h6f1.edges.map((task) => {
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
      const tasks = data.response.tasks;

      let members = [];
      tasks.edges.map((task) => {
        members = [...members, task.node.assignee, task.node.creator];
      });
      UserInjector.injectUserForId([
        ...members
      ]).then(() => (
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_FILTERED,
          tasks,
        })
      ));
    });
  },
  paginateTasks: (filters, endCursor) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_PAGINATING
    });
    const query = TasksQueryRequest.build({endCursor, ...filters});

    TaskManagerGraphQl.query(query, dispatch);
    query.then(data => {
      const tasks = data.response.tasks;

      let members = [];
      tasks.edges.map((task) => {
        members = [...members, task.node.assignee, task.node.creator];
      });
      UserInjector.injectUserForId([
        ...members
      ]).then(() => (
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_PAGINATED,
          tasks,
        })
      ));
    });
  },
  createTask: (taskData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_CREATING
    });
    const mutation = CreateTaskMutationRequest.build(taskData);

    TaskManagerGraphQl.mutation(mutation, dispatch);
    mutation.then(data => {
      const task = data.response.createTask.task;

      UserInjector.injectUserForId([
        task.assignee,
        task.creator
      ]).then(() => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_CREATED,
          task,
        });
        dispatch(
          routeActions.push(
            routes.task.show(
              task.project.organization.slug,
              task.project.slug,
              task.numeric_id
            ))
        );
        dispatch(NotificationActions.addNotification('Task created successfully', 'success'));
      });
    }).catch((response) => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_TASK_CREATE_ERROR,
        errors: response.source.errors
      });
      dispatch(NotificationActions.addNotification('Error while creating task', 'error'));
    });
  },
  updateTask: (taskData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_UPDATING
    });
    const mutation = EditTaskkMutationRequest.build(taskData);

    TaskManagerGraphQl.mutation(mutation, dispatch);
    mutation.then(data => {
      const task = data.response.editTask.task;

      UserInjector.injectUserForId([
        task.assignee,
        task.creator
      ]).then(() => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_UPDATED,
          task,
        });
        dispatch(
          routeActions.push(
            routes.task.show(
              task.project.organization.slug,
              task.project.slug,
              task.numeric_id
            ))
        );
        dispatch(NotificationActions.addNotification('Task updated successfully', 'success'));
      });
    }).catch((response) => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_TASK_UPDATE_ERROR,
        errors: response.source.errors
      });
      dispatch(NotificationActions.addNotification('Error while updating task', 'error'));
    });
  },
  updateTaskProgress: (taskData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_UPDATING_PROGRESS
    });
    const mutation = ChangeTaskProgressMutationRequest.build(taskData);

    TaskManagerGraphQl.mutation(mutation, dispatch);
    mutation
      .then(data => {
        const task = data.response.changeTaskProgress.task;

        UserInjector.injectUserForId([
          task.assignee,
          task.creator
        ]).then(() => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_TASK_UPDATED_PROGRESS,
            task,
          });
          dispatch(NotificationActions.addNotification('Task progress updated successfully', 'success'));
        });
      })
      .catch((response) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_UPDATE_PROGRESS_ERROR,
          errors: response.source.errors
        });
        dispatch(NotificationActions.addNotification('Error while updating task progress', 'error'));
      });
  }
};

export default Actions;
