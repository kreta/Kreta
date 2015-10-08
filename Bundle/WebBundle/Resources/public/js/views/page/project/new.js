/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../../scss/views/page/project/_new.scss';

import {Project} from '../../../models/Project';
import {FormSerializerService} from '../../../service/FormSerializer';
import {NotificationService} from '../../../service/Notification';

export class ProjectNewView extends Backbone.Marionette.ItemView {
  constructor(options = {}) {
    _.defaults(options, {
      className: 'project-new',
      template: _.template($('#project-new-template').html()),
      events: {
        'submit #project-new': 'save'
      }
    });
    super(options);
  }

  save(ev) {
    ev.preventDefault();

    var $actions = $('.issue-new-actions').hide();

    this.model = FormSerializerService.serialize(
      $('#project-new'), Project
    );

    this.model.save(null, {
      success: (model) => {
        App.router.base.navigate(`/project/${model.id}`, true);
        NotificationService.showNotification({
          type: 'success',
          message: 'Project created successfully'
        });
      }, error: () => {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while saving this project'
        });
        $actions.show();
      }
    });
  }
}
