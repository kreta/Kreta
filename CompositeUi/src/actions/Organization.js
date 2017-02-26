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
import CreateOrganizationMutationRequest from './../api/graphql/mutation/CreateOrganizationMutationRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';

const Actions = {
  createOrganization: (organizationInputData) => (dispatch) => {
    dispatch({
      type: ActionTypes.ORGANIZATION_CREATING
    });
    const mutation = CreateOrganizationMutationRequest.build(organizationInputData);

    TaskManagerGraphQl.mutation(mutation, dispatch);
    mutation
      .then(data => {
        const organization = data.response.createOrganization.organization;

        dispatch({
          type: ActionTypes.ORGANIZATION_CREATED,
          organization,
        });
        dispatch(
          routeActions.push(routes.organization.show(organization.slug))
        );
      })
      .catch((response) => {
        dispatch({
          type: ActionTypes.ORGANIZATION_CREATE_ERROR,
          errors: response.source.errors
        });
      });
  }
};

export default Actions;
