/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueType} from '../models/issue-type';

export class IssueTypeCollection extends Backbone.Collection {
  constructor(models, options) {
    this.model = IssueType;

    super(models, options);
  }

  setProject(projectId) {
    this.url = App.config.getBaseUrl() + '/projects/' + projectId + '/issue-types';
    return this;
  }
}
