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
import {EventEmitter} from 'events';

import AppDispatcher from './../dispatcher/AppDispatcher';

class Store extends EventEmitter {
  constructor() {
    this.dispatchId = AppDispatcher.register(this.handleDispatch.bind(this));
  }

  handleDispatch(payload) {}
}

export default {
  Model: Backbone.Model.extend(Store),
  Collection: Backbone.Collection.extend(Store)
};
