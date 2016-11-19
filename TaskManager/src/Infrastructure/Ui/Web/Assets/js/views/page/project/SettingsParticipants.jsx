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

import React from 'react';

import Button from './../../component/Button';
import UserPreview from './../../component/UserPreview';

export default class extends React.Component {
  static propTypes = {
    onParticipantAddClicked: React.PropTypes.func,
    project: React.PropTypes.object
  };

  triggerOnParticipantAddClicked(participant) {
    this.props.onParticipantAddClicked(participant);
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
