/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {FormSerializerService} from '../../../service/form-serializer';
import {NotificationService} from '../../../service/notification';

export class UserInviteView extends Backbone.Marionette.ItemView {
  constructor (options) {
    this.className = 'user-invite';
    this.template = _.template($('#user-invite-template').html());
    this.events = {
      'click @ui.close': 'modalClose',
      'submit @ui.form': 'save'
    };

    this.ui = {
      'close': '.modal-close',
      'form': '#user-invite-form'
    };

    super(options);
  }

  save (ev) {
    ev.preventDefault();
    debugger;
    $.post(App.getBaseUrl() + '/users' , FormSerializerService.serialize(this.ui.form), () => {
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
