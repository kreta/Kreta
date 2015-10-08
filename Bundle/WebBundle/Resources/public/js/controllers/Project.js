/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueListView} from '../views/page/project/IssueList';
import {ProjectNewView} from '../views/page/project/New';
import {ProjectSettingsView} from '../views/page/project/Settings';

import {Project} from '../models/Project';
import {IssueCollection} from '../collections/Issue';

export class ProjectController extends Backbone.Marionette.Controller {
  newAction() {
    App.layout.getRegion('content').show(new ProjectNewView());
    App.vent.trigger('main:full-screen');
  }

  listAction() {
    App.layout.getRegion('modal').show(
      React.render('<ProjectList>')
    );
  }

  showAction(project) {
    var model = this.getCurrentProject(project),
      collection = new IssueCollection();

    collection.fetch({data: {project: model.id}});

    App.layout.getRegion('content').show(
      new IssueListView({model, collection})
    );

    App.vent.trigger('main:full-screen');
  }

  settingsAction(project) {
    App.layout.getRegion('content').show(
      new ProjectSettingsView({model: this.getCurrentProject(project)})
    );
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
