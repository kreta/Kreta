/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Project} from '../../../models/project';

export class ProjectNewView extends Backbone.View {
  constructor () {
    this.className = 'project-new';
    this.template = _.template($('#project-new-template').html());
    this.events = {
      'submit #project-new': 'save'
    };

    super();

    this.render();
  }

  render () {
    this.$el.html(this.template());

    return this;
  }

  save (ev) {
    ev.preventDefault();
    var formData = {};
    $.each($('#project-new').serializeArray(), function (field) {
      formData[this.name] = this.value;
    });

    var project = new Project(formData);

    project.save(null, {
      success: (model) => {
        App.router.navigate('/project/' + model.id, true);
      }
    });
  }
}
