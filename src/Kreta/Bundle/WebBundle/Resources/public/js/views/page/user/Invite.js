/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';

import {Config} from './../../../Config';
import {FormSerializerService} from './../../../service/FormSerializer';
import {NotificationService} from './../../../service/Notification';

export class UserInviteView extends Backbone.Marionette.ItemView {
  constructor(options = {}) {
    _.defaults(options, {
      className: 'user-invite',
      template: _.template($('#user-invite-template').html()),
      events: {
        'click @ui.close': 'modalClose',
        'submit @ui.form': 'save'
      }
    });
    super(options);
  }

  ui() {
    return {
      'close': '.modal-close',
      'form': '#user-invite-form'
    };
  }

  save(ev) {
    ev.preventDefault();

    $.post(`${Config.baseUrl}/users`,
      FormSerializerService.serialize(this.ui.form), () => {
        this.modalClose();
        NotificationService.showNotification({
          type: 'success',
          message: 'User invited to Kreta successfully'
        });
      });

    return false;
  }

  modalClose() {
    this.trigger('modal:close');
  }
}
