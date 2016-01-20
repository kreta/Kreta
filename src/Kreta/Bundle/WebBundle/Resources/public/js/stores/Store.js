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

class CollectionStore extends Backbone.Collection {
  constructor() {
    super();
    this.dispatchId = AppDispatcher.register(this.handleDispatch.bind(this));
    this.emitter = new EventEmitter();
  }

  on(action, callback) {
    this.emitter.on(action, callback);
  }

  handleDispatch(payload) {}
}

class ModelStore extends Backbone.Model {
  constructor(attributes, options) {
    super(attributes, options);
    this.dispatchId = AppDispatcher.register(this.handleDispatch.bind(this));
    this.emitter = new EventEmitter();
  }

  on(action, callback) {
    this.emitter.on(action, callback);
  }

  handleDispatch(payload) {}
}

export default {
  Model: ModelStore,
  Collection: CollectionStore
};
