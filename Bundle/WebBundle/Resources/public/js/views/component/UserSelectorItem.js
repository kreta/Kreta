/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {Config} from '../../Config';
import {NotificationService} from '../../service/Notification';

export class UserSelectorItemView extends Backbone.Marionette.ItemView {
  initialize(options = {}) {
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
    var participant = {
      role: 'ROLE_PARTICIPANT',
      user: this.model.id
    };

    this.ui.addButton.hide();
    $.post(
      `${Config.baseUrl}/projects/${this.project}/participants`,
      participant,
      () => {
        NotificationService.showNotification({
          type: 'success',
          message: 'User added successfully to the project'
        });
        App.vent.trigger('participant:added');
      }
    );
  }
}
