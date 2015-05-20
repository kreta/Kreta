/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Project} from '../../../models/project';

export class ProjectSettingsView extends Backbone.View {
  constructor(options) {
    this.template = _.template($('#project-settings-template').html());
    this.events = {
      'submit #project-edit': 'save'
    };

    super(options);

    this.render();
  }

  render() {
    this.$el.html(this.template(this.model.toJSON()));

    return this;
  }

  save(ev) {
    ev.preventDefault();
    var formData = {};
    $.each($('#project-settings').serializeArray(), function (field) {
      formData[this.name] = this.value;
    });

    var project = new Project(formData);

    project.save(null, {
      success: (model) => {

      }
    });
  }

  addUser() {

  }

  removeUser() {

  }

  changeRole() {

  }
}