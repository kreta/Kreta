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
import ActionTypes from '../constants/ActionTypes';
import {EventEmitter} from 'events';

class Users extends Store.Collection {
  model = User;
  url = `${Config.baseUrl}/users`;

  handleDispatch(payload) {
    switch (payload.type) {

      case ActionTypes.PROFILE_UPDATE:
        this.create(payload.profile, {
          success: (model) => {
            this.emitter.emit(ActionTypes.PROFILE_UPDATED, model);
          },
          error: (model, erros) => {
            this.emitter.emit(ActionTypes.PROFILE_UPDATE_ERROR, errors)
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
