/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import Backbone from 'backbone';
import {Config} from '../config';
import {Issue} from '../models/issue';

export class IssueCollection extends Backbone.Collection {
  constructor(models, options = {}) {
    _.defaults(options, {
      model: Issue
    });
    super(models, options);
  }

  url() {
    return `${Config.baseUrl}/issues`;
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
