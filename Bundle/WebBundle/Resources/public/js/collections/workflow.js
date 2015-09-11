/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Config} from '../config';
import {Workflow} from '../models/workflow';

export class WorkflowCollection extends Backbone.Collection {
  constructor (models, options) {
    this.url = Config.baseUrl + '/workflows';
    this.model = Workflow;
    super(models, options);
  }
}
