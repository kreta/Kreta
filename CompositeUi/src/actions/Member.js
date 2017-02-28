/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from './../constants/ActionTypes';
import Users from './../api/rest/User/Users';

const Actions = {
  fetchMembersToAdd: (query) => (dispatch) => {

    Users.getByName({query})
      .then((users) => {
        dispatch({
          type: ActionTypes.MEMBERS_TO_ADD_RECEIVED,
          users
        });
      });
  }
};

export default Actions;
