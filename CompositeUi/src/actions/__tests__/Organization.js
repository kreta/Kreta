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

import OrganizationActions from '../../actions/Organization';
import ActionTypes from '../../constants/ActionTypes';

describe('Main menu actions', () => {
  it('creates organization', () => {
    const exampleOrganization = {name: 'example'},
      expectedActions = [
        {type: ActionTypes.ORGANIZATION_CREATING},
        {type: ActionTypes.ORGANIZATION_CREATED, organization: exampleOrganization},
        {payload: {arg: "/", method: "push"}, type: "@@router/TRANSITION"}
      ];

    const store = mockStore({});

    store.dispatch(OrganizationActions.createOrganization(exampleOrganization));
    expect(store.getActions()).toEqual(expectedActions);
  });
});
