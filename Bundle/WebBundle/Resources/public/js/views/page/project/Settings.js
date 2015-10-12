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
import $ from 'jquery';

import {Project} from '../../../models/Project';
import {Config} from '../../../Config.js';
import {FormSerializerService} from '../../../service/FormSerializer';
import {NotificationService} from '../../../service/Notification.js';
import UserPreview from '../../component/UserPreview';
import ContentMiddleLayout from '../../layout/ContentMiddleLayout.js';
import ContentRightLayout from '../../layout/ContentRightLayout.js';

export default React.createClass({
  getInitialState() {
    return {
      project: null,
      userSelectorVisible: false
    };
  },
  componentDidMount() {
    const project = App.collection.project.get(this.props.params.projectId);
    project.on('change', (project) => {
     this.setState({
       project,
       notParticipating: this.getNotParticipating(project.get('participants'))
     });
    });
    this.setState({
      project,
      notParticipating: this.getNotParticipating(project.get('participants'))
    });
  },
  getNotParticipating(participants) {
    const notParticipating = [];
    App.collection.user.each((user) => {
      let found = false;
      for (var i = 0; i < participants.length; i++) {
        if (participants[i].user.id === user.get('id')) {
          found = true;
          break;
        }
      }
      if (!found) {
        notParticipating.push(user);
      }
    });
    return notParticipating;
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
  showNotParticipantingList(ev) {
    ev.preventDefault();
    this.setState({
      userSelectorVisible: true
    });
  },
  addParticipant(index) {
    const participant = {
      role: 'ROLE_PARTICIPANT',
      user: this.state.notParticipating[index].id
    };

    $.post(
      `${Config.baseUrl}/projects/${this.state.project.id}/participants`,
      participant,
      () => {
        NotificationService.showNotification({
          message: 'User added successfully to the project'
        });
        //Update participants
        this.state.project.fetch();
      }
    );
  },
  render() {
    if (!this.state.project) {
      return <div>Loading...</div>;
    }

    const participants = this.state.project.get('participants').map((participant, index) => {
      return <UserPreview key={index} user={participant.user}/>;
    });

    const notParticipating = this.state.notParticipating.map((user, index) => {
      const actions = (
        <button className="button green button--icon"
                onClick={this.addParticipant.bind(this, index)}>
          <i className="fa fa-plus"></i>
        </button>
      );
      return (
        <UserPreview actions={actions}
                     key={index}
                     user={user.toJSON()}/>
      );
    });
    return (
      <div>
        <ContentMiddleLayout rightOpen={this.state.userSelectorVisible}>
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
                <a className="button"
                   href="#"
                   onClick={this.showNotParticipantingList}>
                  Add people
                </a>
              </div>
            </div>
            <div className="project-settings__participants">
              {participants}
            </div>
          </section>
        </ContentMiddleLayout>
        <ContentRightLayout open={this.state.userSelectorVisible}>
          <div className="project-settings__not-participating">
            {notParticipating}
          </div>
        </ContentRightLayout>
      </div>
    );
  }
});
