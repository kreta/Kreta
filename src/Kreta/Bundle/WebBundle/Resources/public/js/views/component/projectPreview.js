/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {ProjectController} from '/../controllers/project';

export class ProjectPreviewView extends Backbone.View {
  constructor(options) {
    this.className = 'project-preview';
    this.tagName = 'li';

    this.template = _.template($('#project-preview-template').html());

    this.events = {
      'click .project-preview-link': 'showFullProject'
    };

    super(options);
  }

  render() {
    this.$el.html(this.template(this.model.toJSON()));
    return this;
  }

  showFullProject() {
    App.router.navigate('/project/' + this.model.id, true);
    /*var controller = new ProjectController();
    controller.showAction(this.model);*/
  }
}
