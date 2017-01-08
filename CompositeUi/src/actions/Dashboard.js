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

import OrganizationsQueryRequest from './../api/graphql/query/OrganizationsQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';

const Actions = {
  fetchData: (organizationName) => (dispatch) => {
    dispatch({
      type: ActionTypes.DASHBOARD_DATA_FETCHING
    });
    const query = OrganizationsQueryRequest.build({name: organizationName});

    TaskManagerGraphQl.query(query, dispatch);
    query
      .then(organizationsData => {
        dispatch({
          type: ActionTypes.DASHBOARD_DATA_RECEIVED,
          organizations: organizationsData.response.organizations.edges,
          query: organizationName
        });
      });
  }
};

export default Actions;
