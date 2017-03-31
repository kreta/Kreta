/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import mockStore from './../../__mocks__/mockStore';
import ActionTypes from './../../constants/ActionTypes';

import OrganizationActions from './../../actions/Organization';

describe('Organization actions', () => {
  it('creates organization', async () => {
    const exampleOrganization = {name: 'example'},
      expectedActions = [
        {type: ActionTypes.ORGANIZATION_CREATING},
        {organization: exampleOrganization, type: ActionTypes.ORGANIZATION_CREATED},
        {payload: {arg: '/', method: 'push'}, type: '@@router/TRANSITION'}
      ];

    const store = mockStore({});

    store.dispatch(OrganizationActions.createOrganization(exampleOrganization));
    await expect(store.getActions()).toEqual(expectedActions);
  });
});
