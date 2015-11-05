/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import _ from 'lodash';
import Backbone from 'backbone';

import Config from './../Config';
import Workflow from './../models/Workflow';

class WorkflowCollection extends Backbone.Collection {
  constructor(models, options = {}) {
    _.defaults(options, {
      model: Workflow
    });
    super(models, options);
  }

  url() {
    return `${Config.baseUrl}/workflows`;
  }
}

export default WorkflowCollection;
