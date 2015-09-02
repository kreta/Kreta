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
import {IssueCollection} from '../collections/issue';

export class ProjectController extends Backbone.Marionette.Controller {
  newAction() {
    App.layout.getRegion('content').show(new ProjectNewView());
    App.vent.trigger('main:full-screen');
  }

  listAction() {
    var projects = new ProjectCollection();
    projects.fetch();
    App.layout.getRegion('modal').show(new ProjectListView({collection: projects}));
  }

  showAction(project) {
    var model = this.getCurrentProject(project);
    var collection = new IssueCollection();
    collection.fetch({data: {project: model.id}});

    App.layout.getRegion('content').show(new IssueListView({
      model: model,
      collection: collection
    }));

    App.vent.trigger('main:full-screen');
  }

  settingsAction(project) {
    App.layout.getRegion('content').show(new ProjectSettingsView({
      model: this.getCurrentProject(project)
    }));
    App.vent.trigger('main:full-screen');
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
