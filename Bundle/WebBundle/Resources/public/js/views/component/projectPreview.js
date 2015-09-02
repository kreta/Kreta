/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class ProjectPreviewView extends Backbone.Marionette.ItemView {
  constructor(options) {
    this.className = 'project-preview';
    this.tagName = 'li';

    this.template = _.template($('#project-preview-template').html());

    this.events = {
      'click .project-preview-link': 'showFullProject'
    };

    super(options);
  }

  showFullProject() {
    this.triggerMethod('project:selected');

    App.router.base.navigate('/project/' + this.model.id);
    App.controller.project.showAction(this.model);

    return false;
  }
}
