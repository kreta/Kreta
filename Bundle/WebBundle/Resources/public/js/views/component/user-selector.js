/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {UserSelectorItemView} from './user-selector-item';
import {NotificationService} from '../../service/notification';

export class UserSelectorView extends Backbone.Marionette.CompositeView {
  initialize(options) {
    this.template = '#user-selector-template';
    this.childView = UserSelectorItemView;
    this.childViewContainer = '.user-selector-users';
    this.childViewOptions = {
      project: options.project
    };

    this.ui = {
      actions: '.user-selector-actions',
      invite: '.user-selector-actions-invite',
      search: '.user-selector-actions-search',
      inviteForm: '.user-selector-invite-form',
      inviteFormEmail: '.user-selector-invite-form-email'
    };

    this.events = {
      'click @ui.invite': 'showInvitationForm',
      'click @ui.search': 'showSearchForm',
      'submit @ui.inviteForm': 'sendInvitation'
    }
  }

  showInvitationForm() {
    this.ui.actions.addClass('selected');
    this.ui.inviteForm.addClass('visible');
  }

  sendInvitation() {
    this.ui.actions.removeClass('selected');
    this.ui.inviteForm.removeClass('visible');
    var email = this.ui.inviteFormEmail.val();
    $.post(App.getBaseUrl() + '/users' , {'email': email}, function() {
      NotificationService.showNotification({
        type: 'success',
        message: 'User invited to Kreta successfully'
      });
    });
    return false;
  }
}
