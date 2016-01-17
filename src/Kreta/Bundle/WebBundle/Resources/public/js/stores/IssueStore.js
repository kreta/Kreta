/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {EventEmitter} from 'events';

import AppDispatcher from './../dispatcher/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';

export default class IssueStore extends EventEmitter {
  constructor() {
    super();

    this.dispatchId = AppDispatcher.register(this.handleDispatch.bind(this));
    this.issues = [];
  }

  handleDispatch(payload) {
    switch(payload.type) {
      case ActionTypes.ISSUE_CREATED:
        this.issues.push(payload.issue);
        this.emit(ActionTypes.CHANGE_EVENT);
        this.emit(ActionTypes.ISSUE_CREATED, payload.issue);
    }
  }
}
