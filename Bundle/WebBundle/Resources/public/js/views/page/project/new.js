/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Project} from '../../../models/project';
import {FormSerializerService} from '../../../service/form-serializer';
import {NotificationService} from '../../../service/notification';

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

    var $actions = $('.issue-new-actions').hide();

    this.model = FormSerializerService.serialize(
      $('#project-new'), Project
    );

    this.model.save(null, {
      success: (model) => {
        App.router.base.navigate('/project/' + model.id, true);
        NotificationService.showNotification({
          type: 'success',
          message: 'Project created successfully'
        });
      }, error: function() {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while saving this project'
        });
        $actions.show();
      }
    });
  }
}
