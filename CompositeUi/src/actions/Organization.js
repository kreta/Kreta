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

import CreateOrganizationMutationRequest from './../api/graphql/mutation/CreateOrganizationMutationRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';

const Actions = {
  createOrganization: (organizationInputData) => (dispatch) => {
    const mutation = CreateOrganizationMutationRequest.build(organizationInputData);

    dispatch({
      type: ActionTypes.ORGANIZATION_CREATING
    });
    TaskManagerGraphQl.mutation(mutation, dispatch);

    return mutation
      .then(data => {
        const organization = data.response.createOrganization.organization;

        dispatch({
          type: ActionTypes.ORGANIZATION_CREATED,
          organization,
        });
        dispatch(
          routeActions.push(routes.organization.show(organization.slug))
        );
        dispatch(NotificationActions.addNotification('Organization created successfully', 'success'));
      })
      .catch((response) => {
        dispatch({
          type: ActionTypes.ORGANIZATION_CREATE_ERROR,
          errors: response.source.errors
        });
        dispatch(NotificationActions.addNotification('Error while creating organization', 'error'));
      });
  }
};

export default Actions;
