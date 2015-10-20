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

export class Workflow extends Backbone.Model {
  urlRoot() {
    return `${Config.baseUrl}/workflows`;
  }
}
