/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueController} from '../controllers/issue';

export class IssueRouter extends Backbone.Marionette.AppRouter {
  initialize() {
    this.controller = new IssueController();
    this.appRoutes = {
      'issue/new/:projectId': 'newAction',
      'issue/:id': 'showAction'
    };
  }
}
