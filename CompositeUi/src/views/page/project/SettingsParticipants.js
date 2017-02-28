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
import Search from './../../component/SearchMember';
import MemberActions from './../../../actions/Member';

class SettingsParticipants extends React.Component {
  static propTypes = {
    onMemberRemoveClicked: React.PropTypes.func,
    organization: React.PropTypes.object
  };

  componentDidMount() {
    this.filterMembersToAdd(this.props.location.query.q);
  }

  filterMembersToAdd(q) {
    this.props.dispatch(MemberActions.fetchMembersToAdd(q));
  }

  triggerOnMemberRemoveClicked(participant) {
    this.props.onMemberRemoveClicked(participant);
  }

  renderMembersToAdd() {
    return this.props.organization.filtered.members.map((member, index) => (
      <div className="MemberList" key={index}>
        { member.id }
      </div>
    ));
  }

  onChangeSearch(event) {
    const query = event.target.value;
    console.log(query);
    /* this.props.dispatch(routeActions.push(routes.search(query)));
    this.filterOrganizations(query); */
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
      <div>
        <div className="organization-settings__add_members">
          {notParticipating}
          <Search
            onChange={this.onChangeSearch.bind(this)}
          />
          <div>
            { this.filterMembersToAdd() }
          </div>
        </div>
      </div>
    );
  }
}

export default SettingsParticipants;
