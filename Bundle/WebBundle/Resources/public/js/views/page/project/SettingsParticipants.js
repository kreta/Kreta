/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../../scss/views/page/project/_settings.scss';

import React from 'react';
import $ from 'jquery';

import UserPreview from '../../component/UserPreview';
import {Config} from '../../../Config.js';
import {NotificationService} from '../../../service/Notification.js';

export default React.createClass({
  propTypes: {
    onParticipantAdded: React.PropTypes.func,
    project: React.PropTypes.object
  },
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
  },
  render() {
    const notParticipating = this.props.project.getNotParticipating()
      .map((user, index) => {
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
      <div className="project-settings__not-participating">
        {notParticipating}
      </div>
    );
  }
});
