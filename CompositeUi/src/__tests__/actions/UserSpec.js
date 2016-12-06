/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import mockStore from '../../__mocks__/mockStore';

import UserActions from '../../actions/User';
import ActionTypes from '../../constants/ActionTypes';

jest.mock('../../api/Security');

describe('User actions', () => {
  it('can login with valid credentials', async () => {
    const expectedActions = [
      {type: ActionTypes.USER_AUTHORIZING},
      {type: ActionTypes.USER_AUTHORIZED, token: 'token'},
      {payload: {arg: "/", method: "push"}, type: "@@router/TRANSITION"}
    ];

    const store = mockStore({errors: [], token: null, updatingAuthorization: false});

    await store.dispatch(UserActions.login({email: 'valid@email.com', password: 'password'}));
    expect(store.getActions()).toEqual(expectedActions);
  });

  it('cannot login with invalid credentials', async () => {
    const expectedActions = [
      {type: ActionTypes.USER_AUTHORIZING},
      {type: ActionTypes.USER_AUTHORIZATION_ERROR}
    ];

    const store = mockStore({errors: [], token: null, updatingAuthorization: false});

    await store.dispatch(UserActions.login({email: 'invalid@email.com', password: 'invalid-password'}));
    expect(store.getActions()).toEqual(expectedActions);
  });

  it('can logout', async () => {
    const expectedActions = [
      {type: ActionTypes.USER_UNAUTHORIZING},
      {type: ActionTypes.USER_UNAUTHORIZED},
      {payload: {arg: "/login", method: "push"}, type: "@@router/TRANSITION"}
    ];

    const store = mockStore({errors: [], token: 'token', updatingAuthorization: false});

    await store.dispatch(UserActions.logout());
    expect(store.getActions()).toEqual(expectedActions);
  });
});
