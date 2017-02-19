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

const Actions = {
  fetchOrganization: (slug) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_ORGANIZATION_FETCHING
    });

    setTimeout(() => {
      dispatch({
        type: ActionTypes.CURRENT_ORGANIZATION_RECEIVED,
        organization: {
          name: 'TODO',
          slug
        }
      });
    });
    // const query = OrganizationQueryRequest.build(slug);
    //
    // TaskManagerGraphQl.query(query, dispatch);
    // query
    //   .then(data => {
    //     dispatch({
    //       type: ActionTypes.CURRENT_ORGANIZATION_RECEIVED,
    //       organization: data.response.organization,
    //     });
    //   });
  }
};

export default Actions;
