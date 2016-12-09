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

const Actions = {
  createOrganization: (organization) => (dispatch) => {
    dispatch({
      type: ActionTypes.ORGANIZATION_CREATING
    });
    dispatch({
      type: ActionTypes.ORGANIZATION_CREATED,
      organization
    });
    dispatch(routeActions.push('/'));
  }
};

export default Actions;
