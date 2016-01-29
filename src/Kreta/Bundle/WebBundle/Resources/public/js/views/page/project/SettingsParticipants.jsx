/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../scss/views/page/project/_settings';

import $ from 'jquery';
import React from 'react';

import Button from './../../component/Button';
import Config from './../../../Config';
import NotificationService from './../../../service/Notification';
import UserPreview from './../../component/UserPreview';

class SettingsParticipants extends React.Component {
  static propTypes = {
    onParticipantAddClicked: React.PropTypes.func,
    project: React.PropTypes.object
  };

  triggerOnParticipantAddClicked(participant) {
    this.props.onParticipantAddClicked(participant);
  }

  addParticipant(index) {
    const participant = {
      role: 'ROLE_PARTICIPANT',
      user: this.props.project.getNotParticipating()[index].id
    };

    $.post(
      `${Config.baseUrl}/projects/${this.props.project.id}/participants`,
      participant,
      () => {
        NotificationService.showNotification({
          message: 'User added successfully to the project'
        });
        this.props.onParticipantAdded();
      }
    );
  }

  render() {
    const notParticipating = this.props.project.participants
      .map((user, index) => {
        const actions = (
          <Button color="green"
                  onClick={this.triggerOnParticipantAddClicked.bind(this, user)}
                  type="icon">
            <i className="fa fa-plus"></i>
          </Button>
        );

        return (
          <UserPreview actions={actions}
                       key={index}
                       user={user.user}/>
        );
      });

    return (
      <div className="project-settings__not-participating">
        {notParticipating}
      </div>
    );
  }
}

export default SettingsParticipants;
