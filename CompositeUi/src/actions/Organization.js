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
import GraphQlInstance from './../api/graphql/GraphQl';
import CreateOrganizationMutationRequest from './../api/graphql/mutation/CreateOrganizationMutationRequest';

const Actions = {
  createOrganization: (organizationInputData) => (dispatch) => {
    dispatch({
      type: ActionTypes.ORGANIZATION_CREATING
    });
    const mutation = CreateOrganizationMutationRequest.build(organizationInputData);
    GraphQlInstance.mutation(mutation);
    mutation.then(organizationsData => {
      dispatch({
        type: ActionTypes.ORGANIZATION_CREATED,
        organization: organizationsData.response.createOrganization.organization,
      });
      dispatch(routeActions.push('/'));
    });
  }
};

export default Actions;
