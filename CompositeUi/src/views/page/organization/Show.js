/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import SettingsIcon from './../../../svg/settings';

import React from 'react';
import {connect} from 'react-redux';
import {Link} from 'react-router';

import {routes} from './../../../Routes';

import CurrentOrganizationActions from './../../../actions/CurrentOrganization';

import AddMemberToOrganization from '../organization/AddMemberToOrganization';
import Button from './../../component/Button';
import CardExtended from './../../component/CardExtended';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import Icon from './../../component/Icon';
import InlineLink from './../../component/InlineLink';
import LoadingSpinner from './../../component/LoadingSpinner';
import PageHeader from './../../component/PageHeader';
import SectionHeader from './../../component/SectionHeader';
import Thumbnail from './../../component/Thumbnail';
import UserCard from './../../component/UserCard';
import {Row, RowColumn} from './../../component/Grid';

@connect(state => ({currentOrganization: state.currentOrganization, profile: state.profile.profile}))
class Show extends React.Component {
  state = {
    addParticipantsVisible: false
  };

  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentOrganizationActions.fetchOrganization(params.organization));
  }

  getProjects() {
    const {organization} = this.props.currentOrganization;

    return organization._projects4l96UD.edges.map((project, index) => {
      const currentProject = project.node;

      return (
        <Link key={index} to={routes.project.show(organization.slug, currentProject.slug)}>
          <CardExtended
            subtitle={`10 issues open`}
            thumbnail={<Thumbnail text={`${currentProject.name}`}/>}
            title={`${currentProject.name}`}
          />
        </Link>
      );
    });
  }

  getOwners() {
    const {organization} = this.props.currentOrganization;

    return organization.owners.map((owner, index) => (
      <UserCard key={index} user={owner}/>
    ));
  }

  getMembers() {
    const {organization} = this.props.currentOrganization;

    return organization.organization_members.map((member, index) => (
      <UserCard
        actions={
          <Button
            color="red"
            onClick={this.removeMember.bind(this, member)}
            type="icon"
          />
        }
        key={index}
        user={member}
      />
    ));
  }

  showAddParticipants() {
    this.setState({addParticipantsVisible: true});
  }

  removeMember(member) {
    const {currentOrganization, dispatch, profile} = this.props;

    dispatch(
      CurrentOrganizationActions.removeMember(
        currentOrganization.organization.id,
        member.id,
        profile.user_id
      )
    );
  }

  addMember(member) {
    const {currentOrganization, dispatch} = this.props;

    dispatch(
      CurrentOrganizationActions.addMember(
        currentOrganization.organization.id,
        member.id
      )
    );
  }

  render() {
    const {currentOrganization} = this.props;

    if (currentOrganization.fetching) {
      return <LoadingSpinner/>;
    }

    return (
      <div>
        <ContentMiddleLayout>
          <Row>
            <RowColumn>
              <PageHeader
                thumbnail={
                  <Thumbnail
                    image={null}
                    text={currentOrganization.organization.name}
                  />
                }
                title={currentOrganization.organization.name}
              >
                <Icon color="green" glyph={SettingsIcon} size="small"/>Settings
                <InlineLink to={routes.organization.settings(currentOrganization.organization.slug)}>
                </InlineLink>
                <Link to={routes.project.new(currentOrganization.organization.slug)}>
                  <Button color="green">New project</Button>
                </Link>
              </PageHeader>
            </RowColumn>
            <RowColumn medium={6}>
              <SectionHeader title="Projects"/>
              {this.getProjects()}
            </RowColumn>
            <RowColumn medium={6}>
              <SectionHeader
                actions={
                  <Button color="green">
                    Add Owners
                  </Button>
                }
                title="Owners"
              />
              {this.getOwners()}
              <SectionHeader
                actions={
                  <Button color="green" onClick={this.showAddParticipants.bind(this)}>
                    Add Members
                  </Button>
                }
                title="Members"/>
              {this.getMembers()}
            </RowColumn>
          </Row>
        </ContentMiddleLayout>
        <ContentRightLayout isOpen={this.state.addParticipantsVisible}>
          <AddMemberToOrganization
            onMemberAddClicked={this.addMember.bind(this)}
            organization={this.props.currentOrganization}
          />
        </ContentRightLayout>
      </div>
    );
  }
}

export default Show;
