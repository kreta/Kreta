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
import reducer from './../Profile'

describe('Profile reducer', () => {
  it('has an initial state', () => {
    expect(
      reducer()
    ).toEqual({
      errors: [],
      fetching: false,
      updating: false,
      profile: null
    });
  });

  it('changes state to fetching', () => {
    expect(
      reducer({}, {type: ActionTypes.PROFILE_FETCHING})
    ).toEqual({
      fetching: true
    })
  });

  it('updated state with fetched changes', () => {
    expect(
      reducer({}, {
        type: ActionTypes.PROFILE_RECEIVED,
        profile: {
          id: 1,
        }
      })
    ).toEqual({
      fetching: false,
      profile: {
        id: 1,
      }
    })
  });

  it('flags an error', () => {
    expect(
      reducer({}, {
        type: ActionTypes.PROFILE_FETCH_ERROR,
        errors: ['Some error']
      })
    ).toEqual({
      errors: ['Some error']
    });
  });

  it('changes to updating', () => {
    expect(
      reducer({}, {
        type: ActionTypes.PROFILE_UPDATE
      })
    ).toEqual({
      updating: true
    });
  });

  it('updates profile', () => {
    expect(
      reducer({}, {
        type: ActionTypes.PROFILE_UPDATED,
        profile: {
          username: 'username'
        }
      })
    ).toEqual({
      updating: false,
      profile: {
        username: 'username'
      }
    });
  })
});
