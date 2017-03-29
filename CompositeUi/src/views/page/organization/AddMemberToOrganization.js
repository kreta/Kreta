/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {connect} from 'react-redux';
import React from 'react';

import MemberActions from './../../../actions/Member';

import Button from './../../component/Button';
import Search from './../../component/SearchMember';
import UserCard from './../../component/UserCard';

@connect(state => ({currentOrganization: state.currentOrganization}))
class AddMemberToOrganization extends React.Component {
  static propTypes = {
    onMemberRemoveClicked: React.PropTypes.func,
    organization: React.PropTypes.object
  };

  filterMembersToAdd(query) {
    const {currentOrganization, dispatch} = this.props;

    dispatch(
      MemberActions.fetchMembersToAdd(
        query,
        currentOrganization.organization.organization_members.map((item) => item.id)
      )
    );
  }

  addMember(member) {
    const {onMemberAddClicked} = this.props;

    onMemberAddClicked(member);
  }

  renderMembersToAdd() {
    const {currentOrganization} = this.props;

    return currentOrganization.potential_members
      .map((member, index) => (
        <div className="MemberList" key={index}>
          <UserCard
            actions={
              <Button
                color="green"
                onClick={this.addMember.bind(this, member)}
                type="icon"
              />
            }
            user={member}
          />
        </div>
      ));
  }

  onChangeSearch(event) {
    const query = event.target.value;

    this.filterMembersToAdd(query);
  }

  render() {
    return (
      <div>
        <Search onChange={this.onChangeSearch.bind(this)}/>
        {this.renderMembersToAdd()}
      </div>
    );
  }
}

export default AddMemberToOrganization;
