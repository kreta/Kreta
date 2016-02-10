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
import OrganizationApi from './../api/Organization';

const Actions = {
  fetchOrganizations: () => {
    return (dispatch) => {
      dispatch({
        type: ActionTypes.ORGANIZATIONS_FETCHING
      });
      OrganizationApi.getOrganizations()
        .then((organizations) => {
          dispatch({
            type: ActionTypes.ORGANIZATIONS_RECEIVED,
            organizations
          });
        });
    };
  }
};

export default Actions;
