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

import {Profile} from '../../../models/profile';

export class UserEditView extends Backbone.Marionette.ItemView {
  constructor (options) {
    this.className = 'user-edit';
    this.template = _.template($('#user-edit-template').html());
    this.events = {
      'submit @ui.form': 'save'
    };

    this.ui = {
      'form': '#user-edit-form'
    };

    super(options);
  }

  save (ev) {
    ev.preventDefault();
    this.model = FormSerializerService.serialize(
      this.ui.form, Profile
    );

    this.model.save(null, {
      success: () => {
        NotificationService.showNotification({
          type: 'success',
          message: 'Your profile was updated successfully'
        });
      }, error: () => {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while saving changes'
        });
      }
    });
    return false;
  }
}
