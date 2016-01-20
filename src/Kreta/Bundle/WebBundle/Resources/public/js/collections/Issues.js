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

import Config from './../Config';
import Issue from './../models/Issue';
import ActionTypes from '../constants/ActionTypes';
import Store from '../stores/Store';

class Issues extends Store.Collection {
  model = Issue;

  url() {
    return `${Config.baseUrl}/issues`;
  }

  handleDispatch(payload) {
    switch (payload.type) {

      case ActionTypes.ISSUE_CREATE:
        this.create(payload.issue, {
          success: (model) => {
            this.emitter.emit(ActionTypes.ISSUE_CREATED, model);
          },
          error: (model, errors) => {
            this.emitter.emit(ActionTypes.ISSUE_CREATE_ERROR, errors)
          }
        });

        break;

      default:
        return true;
    }
  }

  findIndexById(issueId) {
    var i = 0;

    while (i < this.models.length) {
      if (this.models[i].get('id') === issueId) {
        return i;
      }
      i++;
    }

    return -1;
  }
}


let IssuesCollection = new Issues();

export default IssuesCollection;
