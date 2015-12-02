/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Backbone from 'backbone';

import AppDispatcher from './../dispatcher/AppDispatcher';
import Config from './../Config';
import Store from './../stores/Store';
import User from './../models/User';

class Users extends Store.Collection {
  model = User;
  url = `${Config.baseUrl}/users`;

  handleDispatch(payload) {
    const action = payload.action;

    switch (action.actionType) {

      case Constants.UPDATE_PROFILE:
        this.create(payload, {
          success: (model) => {
            this.emit(CHANGE_SUCCESS_EVENT, model);
          },
          error: (model, erros) => {
            this.emit(CHANGE_ERROR_EVENT, errors)
          }
        });
        
        break;

      default:
        return true;
    }
  }
}

let UserCollection = new Users();

export default UserCollection;
