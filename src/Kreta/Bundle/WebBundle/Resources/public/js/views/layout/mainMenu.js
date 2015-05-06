/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {User} from '../../models/user';

export class HeaderView extends Backbone.View {
  constructor () {
    super();

    this.setElement($('#kreta-menu-main'));

    this.$userInfo = this.$el.find('.kreta-menu-user');

    this.userInfoTemplate = _.template($('#kreta-menu-user-template').html());

    this.listenTo(App.currentUser, 'change', this.render);

    this.render();
  }

  render () {
    if(App.currentUser.get('id')) {
      this.$userInfo.html(this.userInfoTemplate(App.currentUser.toJSON()));
    }
  }
}
