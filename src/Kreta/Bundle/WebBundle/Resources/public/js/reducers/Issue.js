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
  issue: null
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.ISSUE_UPDATE:
      return {...state, errors: []};

    case ActionTypes.ISSUE_UPDATED:
      return {...state, issue: action.issue};

    case ActionTypes.ISSUE_UPDATE_ERROR:
      return {...state, errors: action.errors};

    default:
      return state;
  }
}
