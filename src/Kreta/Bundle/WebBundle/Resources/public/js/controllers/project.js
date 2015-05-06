/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueListView} from '../views/page/project/issueList';
import {ProjectListView} from '../views/page/project/list';

export class ProjectController extends Backbone.Controller {
  initialize() {
    this.routes = {
      'project/new': 'newAction',
      'project/:id': 'showAction',
      'projects': 'listAction'
    };
  }

  newAction() {
    alert('TODO')
  }

  listAction() {
    var view = new ProjectListView();
    view.show();
  }

  showAction(id) {
    var view = new IssueListView({projectId: id});
    App.views.main.render(view.render().el);
    Backbone.trigger('main:full-screen');
  }
}