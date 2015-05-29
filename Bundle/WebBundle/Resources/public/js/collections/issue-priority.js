/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssuePriority} from '../models/issue-priority';

export class IssuePriorityCollection extends Backbone.Collection {
  constructor(models, options) {
    this.model = IssuePriority;
    super(models, options);
  }

  setProject(projectId) {
    this.url = App.getBaseUrl() + '/projects/' + projectId + '/issue-priorities';
    return this;
  }
}
