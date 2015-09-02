/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Project} from '../../../models/project';

import {UserCollection} from '../../../collections/user';

import {UserSelectorView} from '../../component/user-selector';

import {FormSerializerService} from '../../../service/form-serializer';
import {NotificationService} from '../../../service/notification';

export class ProjectSettingsView extends Backbone.Marionette.ItemView {
  constructor(options) {
    this.template = '#project-settings-template';

    this.ui = {
      'addPeople': '#project-settings-add-people'
    };

    this.events = {
      'submit #project-edit': 'save',
      'click @ui.addPeople': 'addUser'
    };

    super(options);

    this.listenTo(this.model, 'sync', this.render);
    this.listenTo(App.vent, 'participant:added', () => {
      this.model.fetch();
    });
  }

  save(ev) {
    ev.preventDefault();

    var project = FormSerializerService.serialize(
      $('#project-edit'), Project
    );

    project.save(null, {
      success: () => {
        NotificationService.showNotification({
          type: 'success',
          message: 'Saved successfully'
        });
      },
      error: () => {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error updating project settings'
        });
      }
    });
  }

  serializeData() {
    var data = this.model.toJSON();

    data['userIsAdmin'] = this.model.getUserRole(App.currentUser) === 'ROLE_ADMIN';

    return data;
  }

  addUser() {
    var notParticipating = new Backbone.Collection();
    var participants = this.model.get('participants');
    App.collection.user.each(function (user) {
      for(var i = 0; i < participants.length; i++) {
        var found = false;
        if(participants[i].user.id === user.get('id')) {
          found = true;
          break;
        }
      }
      if(!found) {
        notParticipating.push(user);
      }
    });

    var view = new UserSelectorView({
      collection: notParticipating,
      project: this.model.id
    });

    App.layout.getRegion('right-aside').show(view);

    return false;
  }

  onDestroy() {
    this.stopListening();
  }
}
