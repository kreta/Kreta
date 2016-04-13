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
  fetching: true,
  organizations: [],
  selectedRow: 0
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.ORGANIZATIONS_FETCHING:
      return {...state, fetching: true};

    case ActionTypes.ORGANIZATIONS_RECEIVED:
      return {...state, organizations: action.organizations, fetching: false};

    case ActionTypes.ORGANIZATIONS_CREATING:
      return {...state, errors: []};

    case ActionTypes.ORGANIZATIONS_CREATED:
      return {...state, organizations: [...state.organizations, action.organization]};

    case ActionTypes.ORGANIZATIONS_CREATE_ERROR:
      return {...state, errors: action.errors};

    default:
      return state;
  }
}
