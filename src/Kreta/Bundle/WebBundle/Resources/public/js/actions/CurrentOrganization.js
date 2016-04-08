/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from '../constants/ActionTypes';
import {organizationApiPrivateInstance} from '../api/ApiPrivate';

const Actions = {
  fetchOrganization: (organization) => {
    return (dispatch) => {
      dispatch({
        type: ActionTypes.CURRENT_ORGANIZATION_FETCHING
      });

      organizationApiPrivateInstance.getOrganization(organization)
        .then((receivedOrganization) => {
          dispatch({
            type: ActionTypes.CURRENT_ORGANIZATION_RECEIVED,
            organization: receivedOrganization
          });
        });
    };
  }
};

export default Actions;
