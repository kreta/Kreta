/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Config} from '../../config';
import {NotificationService} from '../../service/notification';

export class UserSelectorItemView extends Backbone.Marionette.ItemView {
  initialize(options) {
    this.template = '#user-selector-item-template';

    this.ui = {
      'addButton': '.project-settings-participant-add'
    };

    this.events = {
      'click @ui.addButton': 'addParticipant'
    };

    this.project = options.project;
  }

  addParticipant() {
    this.ui.addButton.hide();

    var participant = {
      role: 'ROLE_PARTICIPANT',
      user: this.model.id
    };

    $.post(Config.baseUrl + '/projects/' + this.project + '/participants' , participant, function() {
      NotificationService.showNotification({
        type: 'success',
        message: 'User added successfully to the project'
      });
      App.vent.trigger('participant:added');
    });
  }
}
