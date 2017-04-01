/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from './../../constants/ActionTypes'
import reducer from './../Dashboard'

describe('Dashboard reducer', () => {
  it('has an initial state', () => {
    expect(
      reducer()
    ).toEqual({
      errors: false,
      fetching: true,
      organizations: [],
      searchQuery: ''
    });
  });

  it('changes state to fetching', () => {
    expect(
      reducer({}, {type: ActionTypes.DASHBOARD_DATA_FETCHING})
    ).toEqual({
      fetching: true
    })
  });

  it('updated state with fetched changes', () => {
    expect(
      reducer({}, {
        type: ActionTypes.DASHBOARD_DATA_RECEIVED,
        organizations: [{
          id: 1,
          name: 'Organization'
        }],
        query: 'org'
      })
    ).toEqual({
      fetching: false,
      organizations:  [{
        id: 1,
        name: 'Organization'
      }],
      searchQuery: 'org'
    })
  });

  it('flags an error', () => {
    expect(
      reducer({}, {type: ActionTypes.DASHBOARD_DATA_FETCH_ERROR})
    ).toEqual({
      error: true
    });
  });
});
