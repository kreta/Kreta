/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {UserController} from '../controllers/user';

export class UserRouter extends Backbone.Marionette.AppRouter {
  initialize() {
    this.controller = new UserController();
    this.appRoutes = {
      'profile/edit': 'editAction'
    };
  }
}
