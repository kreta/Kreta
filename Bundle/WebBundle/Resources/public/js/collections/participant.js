/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Participant} from '../models/participant';

export class ParticipantCollection extends Backbone.Collection {
  constructor (models, options) {
    this.model = Participant;
    super(models, options);
  }

  setProject (projectId) {
    this.url = App.config.getBaseUrl() + '/projects/' + projectId + '/participants';
    return this;
  }
}
