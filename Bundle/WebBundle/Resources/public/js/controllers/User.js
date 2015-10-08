/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {UserEditView} from '../views/page/user/Edit';

export class UserController extends Backbone.Marionette.Controller {
  editAction() {
    App.layout.getRegion('content').show(new UserEditView({
      model: App.currentUser
    }));
    App.vent.trigger('main:full-screen');
  }
}
