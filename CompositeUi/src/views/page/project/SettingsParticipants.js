/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/project/_settings';

import React from 'react';

import Button from './../../component/Button';
import UserCard from './../../component/UserCard';

class SettingsParticipants extends React.Component {
  static propTypes = {
    onMemberRemoveClicked: React.PropTypes.func,
    organization: React.PropTypes.object
  };

  triggerOnMemberRemoveClicked(participant) {
    this.props.onMemberRemoveClicked(participant);
  }

  render() {
    const notParticipating = this.props.organization.organization.organization_members
      .map((user, index) => {
        const actions = (
          <Button color="red"
                  onClick={this.triggerOnMemberRemoveClicked.bind(this, user)}
                  type="icon">
            <i className="fa fa-plus"/>
          </Button>
        );

        return (
          <UserCard actions={actions}
                       key={index}
                       user={user}/>
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
