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
import {ProjectCollection} from '../collections/project';

export class ProjectController extends Backbone.Marionette.Controller {
  newAction() {
    App.layout.getRegion('content').show(new ProjectNewView());
    Backbone.trigger('main:full-screen');
  }

  listAction() {
    var projects = new ProjectCollection();
    projects.fetch();
    App.layout.getRegion('left-aside').show(new ProjectListView({collection: projects}));
  }

  showAction(project) {
    App.layout.getRegion('content').show(new IssueListView({model: this.getCurrentProject(project)}));
    Backbone.trigger('main:full-screen');
  }

  settingsAction(project) {
    App.layout.getRegion('content').show(new ProjectSettingsView({model: this.getCurrentProject(project)}));
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
