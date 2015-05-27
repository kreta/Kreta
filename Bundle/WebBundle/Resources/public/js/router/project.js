/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {ProjectController} from '../controllers/project';

export class ProjectRouter extends Backbone.Marionette.AppRouter {
  initialize() {
    this.controller = new ProjectController();
    this.appRoutes = {
      'project/:id': 'showAction',
      'project/:id/settings': 'settingsAction',
      'project/new': 'newAction',
      'projects': 'listAction'
    };
  }
}
