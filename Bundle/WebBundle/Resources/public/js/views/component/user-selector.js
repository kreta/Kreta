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
      'click @ui.search': 'showSearchForm',
      'scroll': 'relocateFixedFooter',
    }
  }

  onRender() {
    this.relocateFixedFooter();
  }

  relocateFixedFooter() {
    this.ui.actions.css('top', this.$el.scrollTop() + $(window).height() - this.ui.actions.height());
  }

  showInvitationForm() {
    var view = new UserInviteView({});
    App.layout.getRegion('modal').show(view);
  }
}
