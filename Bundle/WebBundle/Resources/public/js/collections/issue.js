/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Config} from '../config';
import {Issue} from '../models/issue';

export class IssueCollection extends Backbone.Collection {
  constructor(models, options) {
    this.model = Issue;
    this.url = `${Config.baseUrl}/issues`;

    super(models, options);
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
