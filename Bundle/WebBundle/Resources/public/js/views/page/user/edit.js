/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {FormSerializerService} from '../../../service/FormSerializer';
import {NotificationService} from '../../../service/Notification';

import {Profile} from '../../../models/Profile';

export class UserEditView extends Backbone.Marionette.ItemView {
  initialize() {
    this.className = 'user-edit';
    this.template = _.template($('#user-edit-template').html());
    this.events = {
      'submit @ui.form': 'save',
      'change @ui.photo': 'onPhotoChange'
    };
    this.originalImage = this.model.get('photo').name;
  }

  ui() {
    return {
      'form': '#user-edit-form',
      'photo': '#photo',
      'previewImage': '#preview-image'
    };
  }

  onPhotoChange(ev) {
    var file = $(ev.currentTarget)[0].files[0];
    if (typeof file === 'undefined') {
      this.ui.previewImage[0].src = this.originalImage;
    } else {
      this.ui.previewImage[0].src = window.URL.createObjectURL(file);
    }
  }

  save(ev) {
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
