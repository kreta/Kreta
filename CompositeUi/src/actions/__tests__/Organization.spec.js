/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/* eslint-disable max-nested-callbacks */

import mockStore from './../../__mocks__/mockStore';
import ActionTypes from './../../constants/ActionTypes';

import OrganizationActions from './../../actions/Organization';

jest.mock('./../../api/graphql/mutation/CreateOrganizationMutationRequest');

describe('Organization actions', () => {
  it('creates organization', () => {
    const
      store = mockStore({}),
      expectedActions = [{
        type: ActionTypes.ORGANIZATION_CREATING
      }, {
        organization: {
          id: 'organization-id',
          name: 'New organization',
          slug: 'new-organization'
        },
        type: ActionTypes.ORGANIZATION_CREATED
      }, {
        payload: {
          arg: '/new-organization',
          method: 'push'
        },
        type: '@@router/TRANSITION'
      }, {
        notification: {
          id: expect.any(Number),
          message: 'Organization created successfully',
          type: 'success'
        },
        type: ActionTypes.NOTIFICATION_ADD
      }];

    store.dispatch(OrganizationActions.createOrganization({name: 'New organization'})).then(() => {
      expect(store.getActions()).toEqual(expectedActions);
    });
  });

  it('does not create organization when the name is empty', () => {
    const
      store = mockStore({}),
      expectedActions = [{
        type: ActionTypes.ORGANIZATION_CREATING
      }, {
        errors: [],
        type: ActionTypes.ORGANIZATION_CREATE_ERROR
      }, {
        notification: {
          id: expect.any(Number),
          message: 'Error while creating organization',
          type: 'error'
        },
        type: ActionTypes.NOTIFICATION_ADD
      }];

    store.dispatch(OrganizationActions.createOrganization({})).then(() => {
      expect(store.getActions()).toEqual(expectedActions);
    });
  });
});
