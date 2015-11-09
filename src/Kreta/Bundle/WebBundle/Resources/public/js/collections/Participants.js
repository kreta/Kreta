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
import Participant from './../models/Participant';

class Participants extends Backbone.Collection {
  model = Participant;

  setProject(projectId) {
    this.url = `${Config.baseUrl}/projects/${projectId}/participants`;

    return this;
  }
}

export default Participants;
