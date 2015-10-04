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
import {Workflow} from '../models/workflow';

export class WorkflowCollection extends Backbone.Collection {
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
