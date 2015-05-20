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
import {ProjectNewView} from '../views/page/project/new';
import {ProjectSettingsView} from '../views/page/project/settings';
import {Project} from '../models/project';

export class ProjectController extends Backbone.Controller {
  initialize() {
    this.routes = {
      'project/:id': 'showAction',
      'project/:id/settings': 'settingsAction',
      'project/new': 'newAction',
      'projects': 'listAction'
    };
  }

  newAction() {
    var view = new ProjectNewView();
    App.views.main.render(view.render().el);
    Backbone.trigger('main:full-screen');
  }

  listAction() {
    var view = new ProjectListView();
    view.show();
  }

  showAction(project) {
    var view = new IssueListView({model: this.getCurrentProject(project)});
    App.views.main.render(view.render().el);
    Backbone.trigger('main:full-screen');
  }

  settingsAction(project) {
    var view = new ProjectSettingsView({model: this.getCurrentProject(project)});
    App.views.main.render(view.render().el);
    Backbone.trigger('main:full-screen');
  }

  getCurrentProject(project) {
    var model = project;
    if (!(project instanceof Project)) {
      model = new Project({id: project});
      model.fetch();
    }

    return model;
  }
}
