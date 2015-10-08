/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import Backbone from 'backbone';
import {Config} from '../Config';
import {IssuePriority} from '../models/IssuePriority';

export class IssuePriorityCollection extends Backbone.Collection {
  constructor(models, options = {}) {
    _.defaults(options, {
      model: IssuePriority
    });
    super(models, options);
  }

  setProject(projectId) {
    this.url = `${Config.baseUrl}/projects/${projectId}/issue-priorities`;

    return this;
  }
}
