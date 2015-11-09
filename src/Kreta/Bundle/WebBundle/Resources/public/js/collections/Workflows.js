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
import Workflow from './../models/Workflow';

class Workflows extends Backbone.Collection {
  model = Workflow;

  url() {
    return `${Config.baseUrl}/workflows`;
  }
}

export default Workflows;
