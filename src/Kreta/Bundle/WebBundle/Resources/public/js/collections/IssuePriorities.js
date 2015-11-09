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
import IssuePriority from './../models/IssuePriority';

class IssuePriorities extends Backbone.Collection {
  model = IssuePriority;

  setProject(projectId) {
    this.url = `${Config.baseUrl}/projects/${projectId}/issue-priorities`;

    return this;
  }
}

export default IssuePriorities;
