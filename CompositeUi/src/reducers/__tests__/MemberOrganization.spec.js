/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from './../../constants/ActionTypes';
import reducer from './../MemberOrganization';

describe('Member organization reducer tests', () => {
  it('Unknow action', () => {
    expect(reducer({}, {type: 'UNKNOWN ACTION'})).toEqual({});
  });

  it('Retrieve members action', () => {
    expect(
      reducer(
        {},
        {
          type: ActionTypes.MEMBERS_TO_ADD_RECEIVED,
          users: [
            {id: 1, userName: 'User 1', fullName: 'Fullname 2'},
            {id: 1, userName: 'User 2', fullName: 'Fullname 3'},
          ],
        },
      ),
    ).toEqual({
      fetching: false,
      potential_members: [
        {id: 1, userName: 'User 1', fullName: 'Fullname 2'},
        {id: 1, userName: 'User 2', fullName: 'Fullname 3'},
      ],
    });
  });
});
