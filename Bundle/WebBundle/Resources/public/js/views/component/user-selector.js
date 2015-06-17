/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {UserSelectorItemView} from './user-selector-item';
import {UserInviteView} from '../page/user/invite';

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
      search: '.user-selector-actions-search'
    };

    this.events = {
      'click @ui.invite': 'showInvitationForm',
      'click @ui.search': 'showSearchForm'
    }
  }

  showInvitationForm() {
    var view = new UserInviteView({});
    App.layout.getRegion('modal').show(view);
  }
}
