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
import TasksQueryRequest from './../api/graphql/query/TasksQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';
import Users from './../api/rest/User/Users';

const Actions = {
  fetchProject: (organizationSlug, projectSlug) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_FETCHING
    });

    const project = {
      id: '1',
      name: 'Dummy Project',
      slug: projectSlug,
      organization: {
        id: '1',
        name: 'Dummy Organization',
        slug: organizationSlug,
        organization_members: [
          {
            "id": "8eb29ed7-93b2-4c94-bb9b-ad4b323ad8c5"
          },
          {
            "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
          }
        ],
        owners: [
          {
            "id": "da49c01f-2e99-45ee-9557-eb3eb57b06c5"
          }
        ]
      },
      _tasks4hn9we: {
        edges: []
      }
    };

    const
      organization = project.organization,
      ids = [];

    organization.owners.map((owner) => {
      ids.push(owner.id);
    });
    organization.organization_members.map((organizationMember) => {
      ids.push(organizationMember.id);
    });

    Users.get({ids})
      .then((users) => {
        // eslint-disable-next-line
        users.map((user, index) => {
          const
            owner = organization.owners[index],
            reverseIndex = users.length - index - 1,
            member = organization.organization_members[reverseIndex];

          if (typeof owner !== 'undefined' && owner.id === user.id) {
            Object.assign(organization.owners[index], user);
          }

          if (typeof member !== 'undefined' && member.id === user.id) {
            Object.assign(organization.organization_members[reverseIndex], user);
          }
        });

        project.organization = organization;
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_RECEIVED,
          project,
        });
      });


    // const query = ProjectQueryRequest.build(projectId);
    //
    // TaskManagerGraphQl.query(query, dispatch);
    // query
    //   .then(data => {
    //     dispatch({
    //       type: ActionTypes.CURRENT_PROJECT_RECEIVED,
    //       project: data.response.project,
    //     });
    //   });
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
