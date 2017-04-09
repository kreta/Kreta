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
import CreateProjectMutationRequest from './../api/graphql/mutation/CreateProjectMutationRequest';
import EditProjectMutationRequest from './../api/graphql/mutation/EditProjectMutationRequest';
import OrganizationQueryRequest from './../api/graphql/query/OrganizationQueryRequest';
import Organization from './../api/rest/User/Organization';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';
import UserInjector from './../helpers/UserInjector';

const Actions = {
  fetchOrganization: (slug) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_ORGANIZATION_FETCHING
    });
    const query = OrganizationQueryRequest.build(slug);

    TaskManagerGraphQl.query(query, dispatch);
    query
      .then(data => {
        const organization = data.response.organization;

        UserInjector.injectUserForId([
          ...organization.organization_members,
          ...organization.owners,
        ]).then(() => (
          dispatch({
            type: ActionTypes.CURRENT_ORGANIZATION_RECEIVED,
            organization,
          })
        ));
      });
  },
  createProject: (projectInputData) => (dispatch) => {
    dispatch({
      type: ActionTypes.PROJECT_CREATING
    });
    const mutation = CreateProjectMutationRequest.build(projectInputData);

    TaskManagerGraphQl.mutation(mutation, dispatch);
    mutation
      .then(data => {
        const project = data.response.createProject.project;

        dispatch({
          type: ActionTypes.PROJECT_CREATED,
          project,
        });
        dispatch(
          routeActions.push(routes.project.show(project.organization.slug, project.slug))
        );
        dispatch(NotificationActions.addNotification('Project created successfully', 'success'));
      })
      .catch((response) => {
        dispatch({
          type: ActionTypes.PROJECT_CREATE_ERROR,
          errors: response.source.errors
        });
        dispatch(NotificationActions.addNotification('Errors found while creating project', 'error'));
      });
  },
  editProject: (projectInputData) => (dispatch) => {
    dispatch({
      type: ActionTypes.PROJECT_EDITING
    });
    const mutation = EditProjectMutationRequest.build(projectInputData);

    TaskManagerGraphQl.mutation(mutation, dispatch);
    mutation
      .then(data => {
        const project = data.response.editProject.project;

        dispatch({
          type: ActionTypes.PROJECT_EDITED,
          project,
        });
        dispatch(
          routeActions.push(routes.project.show(project.organization.slug, project.slug))
        );
        dispatch(NotificationActions.addNotification('Project edited successfully', 'success'));
      })
      .catch((response) => {
        dispatch({
          type: ActionTypes.PROJECT_EDIT_ERROR,
          errors: response.source.errors
        });
        dispatch(NotificationActions.addNotification('Errors found while editing project', 'error'));
      });
  },
  addMember: (organization, user) => (dispatch) => {
    Organization.post(organization.id, user.id)
      .then(() => {
        dispatch({
          type: ActionTypes.CURRENT_ORGANIZATION_MEMBER_ADDED,
          user
        });
        dispatch(NotificationActions.addNotification('Member added successfully to project', 'success'));
      });
  },
  removeMember: (organization, user, remover) => (dispatch) => {
    Organization.delete(organization, user, remover)
      .then(() => {
        dispatch({
          type: ActionTypes.CURRENT_ORGANIZATION_MEMBER_REMOVED,
          user
        });
        dispatch(NotificationActions.addNotification('Member removed successfully from project', 'success'));
      });
  }
};

export default Actions;
