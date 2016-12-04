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
  it('can login with valid credentials', async () => {
    const expectedActions = [
      {type: ActionTypes.USER_AUTHORIZING},
      {type: ActionTypes.USER_AUTHORIZED, token: 'token'},
      {payload: {arg: "/", method: "push"}, type: "@@router/TRANSITION"}
    ];

    const store = mockStore({errors: [], token: null, updatingAuthorization: false});

    await store.dispatch(UserActions.login({username: 'username', password: 'password'}));
    expect(store.getActions()).toEqual(expectedActions);
  });

  it('cannot login with invalid credentials', async () => {
    const expectedActions = [
      {type: ActionTypes.USER_AUTHORIZING}
    ];

    const store = mockStore({errors: [], token: null, updatingAuthorization: false});

    await store.dispatch(UserActions.login({username: 'username', password: 'invalid-password'}));
    expect(store.getActions()).toEqual(expectedActions);
  });

  it('can logout', () => {

  });
});
