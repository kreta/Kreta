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

const initialState = {
  errors: [],
  fetchingOrganization: true,
  organization: null
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.CURRENT_ORGANIZATION_FETCHING:
      return {...state, fetchingOrganization: true};

    case ActionTypes.CURRENT_ORGANIZATION_RECEIVED:
      return {...state, organization: action.organization, fetchingProjects: false};

    default:
      return state;
  }
}
