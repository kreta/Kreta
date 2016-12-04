/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import configureMockStore from 'redux-mock-store'
import thunk from 'redux-thunk'

import UserActions from '../../actions/User';
import ActionTypes from '../../constants/ActionTypes';

const middlewares = [thunk],
  mockStore = configureMockStore(middlewares);

jest.mock('../../api/Security');

describe('User actions', () => {
  it('can login with valid credentials', () => {
    const expectedActions = [
      {type: ActionTypes.USER_AUTHORIZING},
      {type: ActionTypes.USER_AUTHORIZED, token: 'token'}
    ];

    const store = mockStore({errors: [], token: null, updatingAuthorization: false});

    return store.dispatch(UserActions.login({username: 'username', password: 'password'}))
      .then(() => {
        expect(store.getActions()).toEqual(expectedActions);
      });
  });

  it('cannot login with invalid credentials', () => {

  });

  it('can logout', () => {

  });
});
