/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {UserSelectorItemView} from './user-selector-item';

export class UserSelectorView extends Backbone.Marionette.CollectionView {
  initialize(options) {
    this.template = '#user-selector-template';
    this.childView = UserSelectorItemView;
    this.childViewOptions = {
      'project': options.project
    }
  }
}
