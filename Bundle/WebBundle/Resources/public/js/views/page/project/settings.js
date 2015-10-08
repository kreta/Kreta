/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../../scss/views/page/project/_settings.scss';

import React from 'react';

import {Project} from '../../../models/Project';
import {UserSelectorView} from '../../component/UserSelector';
import {FormSerializerService} from '../../../service/FormSerializer';

export default React.createClass({
  getInitialState() {
    return {
      project: null
    };
  },
  componentDidMount() {
    this.setState({
      project: App.collection.project.get(this.props.params.projectId)
    });
  },
  saveProject(ev) {
    ev.preventDefault();

    var project = FormSerializerService.serialize(
      $(this.refs.settingsForm.getDOMNode()), Project
    );

    project.save(null, {
      success: () => {
        console.log('Project settings Ok');
      },
      error: () => {
        console.log('Project settings Ko');
      }
    });
  },
  addUser() {
  },
  render() {
    if (!this.state.project) {
      return <div>Loading...</div>;
    }

    const participants = this.state.project.get('participants').map((participant, index) => {
      return <UserPreview key={index} user={participant}/>;
    });
    return (
      <div>
        <form className="spacer-top-4"
              onSubmit={this.saveProject}
              ref="settingsForm">
          <div className="section-header">
            <div className="section-header-title"></div>
            <div>
              <button className="button">Cancel</button>
              <button className="button green"
                      tabIndex="3"
                      type="submit">
                Done
              </button>
            </div>
          </div>
          <input name="id" type="hidden" value={this.state.project.id}/>
          <input className="big"
                 defaultValue={this.state.project.get('name')}
                 name="name"
                 placeholder="Type your project name"
                 tabIndex="1"
                 type="text"/>
          <input defaultValue={this.state.project.get('short_name')}
                 name="short_name"
                 placeholder="Type a short name for your project"
                 tabIndex="2"
                 type="text"/>
        </form>
        <section className="spacer-vertical-1">
          <div className="section-header">
              <h3 className="section-header-title">
                <strong>People</strong> in this project
              </h3>
              <div className="section-header-actions">
                  <a className="button" href="#" onClick={this.addPeople}>
                      Add people
                  </a>
              </div>
          </div>
            {participants}
          <div>
          </div>
        </section>
      </div>
    );
  }
});
/*
>>>>>>> Refactored Project New and Settings pages

export class ProjectSettingsView extends Backbone.Marionette.ItemView {
  constructor(options = {}) {
    _.defaults(options, {
      className: `notification ${options.model.type}`,
      template: '#project-settings-template',
      events: {
        'submit #project-edit': 'save',
        'click @ui.addPeople': 'addUser'
      }
    });
    super(options);

    this.listenTo(this.model, 'sync', this.render);
    this.listenTo(App.vent, 'participant:added', () => {
      this.model.fetch();
    });
  }

  ui() {
    return {
      'addPeople': '#project-settings-add-people'
    };
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

    data.userIsAdmin = this.model.getUserRole(App.currentUser) === 'ROLE_ADMIN';

    return data;
  }

  addUser() {
    var notParticipating = new Backbone.Collection(),
      participants = this.model.get('participants'),
      view,
      found;

    App.collection.user.each((user) => {
      for (var i = 0; i < participants.length; i++) {
        found = false;
        if (participants[i].user.id === user.get('id')) {
          found = true;
          break;
        }
      }
      if (!found) {
        notParticipating.push(user);
      }
    });

    view = new UserSelectorView({
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
*/
