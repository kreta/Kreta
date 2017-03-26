/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import reducer from '../MemberOrganization'
import ActionTypes from '../../constants/ActionTypes'
import * as Fixtures from '../../tests/Fixtures'

describe('Member organization reducer tests', () => {
    it('Unknow  action', () => {
        expect(
            reducer({}, {'type':'UNKNOWN ACTION'})
        ).toEqual(
            {}
        );
    }),
    it('Retrieve members  action', () => {
        expect(
            reducer({}, {'type':ActionTypes.MEMBERS_TO_ADD_RECEIVED, users: Fixtures.users})
        ).toEqual(
            {
                fetching: false,
                potential_members: Fixtures.users
            }
        );
    })
});