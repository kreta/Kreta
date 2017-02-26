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
import CreateProjectMutationRequest from './../api/graphql/mutation/CreateProjectMutationRequest';
import OrganizationQueryRequest from './../api/graphql/query/OrganizationQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';
import Users from './../api/rest/User/Users';

const Actions = {
  fetchOrganization: (slug) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_ORGANIZATION_FETCHING
    });
    const query = OrganizationQueryRequest.build(slug);

    TaskManagerGraphQl.query(query, dispatch);
    query
      .then(data => {
        const
          organization = data.response.organization,
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

            dispatch({
              type: ActionTypes.CURRENT_ORGANIZATION_RECEIVED,
              organization,
            });
          });
      });
  },
  createProject: (projectInputData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_ORGANIZATION_PROJECT_CREATING
    });
    const mutation = CreateProjectMutationRequest.build(projectInputData);

    TaskManagerGraphQl.mutation(mutation, dispatch);
    mutation
      .then(data => {
        const project = data.response.createProject.project;

        dispatch({
          type: ActionTypes.CURRENT_ORGANIZATION_PROJECT_CREATED,
          project,
        });
        dispatch(
          routeActions.push(routes.project.show(project.organization.slug, project.slug))
        );
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.CURRENT_ORGANIZATION_PROJECT_CREATE_ERROR,
            errors
          });
        });
      });
  }
};

export default Actions;
