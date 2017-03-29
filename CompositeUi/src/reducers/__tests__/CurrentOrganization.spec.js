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
import reducer from './../CurrentOrganization'

describe('Current organization reducer tests', () => {
  it('Initial State', () => {
    expect(
      reducer()
    ).toEqual({
      fetching: true,
      organization: null,
      potential_members: [],
      projects: []
    });
  });

  it('Organization fetching', () => {
    expect(
      reducer({}, {type: ActionTypes.CURRENT_ORGANIZATION_FETCHING})
    ).toEqual({
      fetching: true
    })
  });

  it('Organization received', () => {
    expect(
      reducer({}, {
        type: ActionTypes.CURRENT_ORGANIZATION_RECEIVED,
        organization: {
          id: 1,
          name: 'Organization 1',
          organization_members: [{
            id: 'id1'
          }, {
            id: 'id2'
          }]
        }
      })
    ).toEqual({
      fetching: false,
      organization: {
        id: 1,
        name: 'Organization 1',
        organization_members: [{
          id: 'id1'
        }, {
          id: 'id2'
        }]
      }
    })
  });

  it('Organization member removed', () => {
    return expect(
      reducer({
        organization: {
          id: 1,
          name: 'Organization 1',
          organization_members: [{
            id: 'id1'
          }, {
            id: 'id2'
          }]
        }
      }, {
        type: ActionTypes.CURRENT_ORGANIZATION_MEMBER_REMOVED,
        user: {
          id: 'id2'
        }
      })
    ).toEqual({
      fetching: false, organization: {
        id: 1,
        name: 'Organization 1',
        organization_members: [{
          id: 'id1'
        }]
      }
    })
  });

  it('Organization member add', () => {
    expect(
      reducer({
        organization: {
          id: 1,
          name: 'Organization 1',
          organization_members: [{
            id: 'id1'
          }]
        },
        potential_members: [
          {id: 'id2'}
        ]
      }, {
        type: ActionTypes.CURRENT_ORGANIZATION_MEMBER_ADDED,
        user: {
          id: 'id1'
        }
      })
    ).toEqual({
      fetching: false,
      organization: {
        id: 1,
        name: 'Organization 1',
        organization_members: [{
          id: 'id1'
        }, {
          id: 'id2'
        }]
      },
      potential_members: []
    })
  })
});
