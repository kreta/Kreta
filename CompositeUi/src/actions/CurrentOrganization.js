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
import OrganizationQueryRequest from './../api/graphql/query/OrganizationQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';

const Actions = {
  fetchOrganization: (slug) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_ORGANIZATION_FETCHING
    });
    const query = OrganizationQueryRequest.build(slug);

    TaskManagerGraphQl.query(query, dispatch);
    query
      .then(data => {
        dispatch({
          type: ActionTypes.CURRENT_ORGANIZATION_RECEIVED,
          organization: data.response.organization,
        });
      });
  }
};

export default Actions;
