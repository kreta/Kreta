/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {UserSelectorItemView} from './UserSelectorItem';
import {UserInviteView} from '../page/user/Invite';

export class UserSelectorView extends Backbone.Marionette.CompositeView {
  initialize(options = {}) {
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
      'scroll': 'relocateFixedFooter'
    };
  }

  onRender() {
    this.relocateFixedFooter();
  }

  relocateFixedFooter() {
    this.ui.actions.css(
      'top',
      `${this.$el.scrollTop()}${$(window).height() - this.ui.actions.height()}`
    );
  }

  showInvitationForm() {
    var view = new UserInviteView({});
    App.layout.getRegion('modal').show(view);
  }
}
