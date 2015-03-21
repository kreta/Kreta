/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Issue} from '../models/issue';

export class IssueCollection extends Backbone.Collection {
  constructor (models, options) {
    this.model = Issue;
    this.url = App.config.getBaseUrl() + '/issues';
    super(models, options);
  }
}
