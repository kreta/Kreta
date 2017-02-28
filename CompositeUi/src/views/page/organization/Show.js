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

import Button from './../../component/Button';
import CardExtended from './../../component/CardExtended';
import Icon from './../../component/Icon';
import InlineLink from './../../component/InlineLink';
import LoadingSpinner from './../../component/LoadingSpinner';
import PageHeader from './../../component/PageHeader';
import {Row, RowColumn} from './../../component/Grid';
import AddMemberToOrganization from '../organization/AddMemberToOrganization';
import SectionHeader from './../../component/SectionHeader';
import Thumbnail from './../../component/Thumbnail';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import CurrentOrganizationActions from './../../../actions/CurrentOrganization';
import UserCard from './../../component/UserCard';

@connect(state => ({currentOrganization: state.currentOrganization}))
class Show extends React.Component {
  state = {
    addParticipantsVisible: false
  };

  componentDidMount() {
    console.log(this.props);
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
      <UserCard key={index} user={member}/>
    ));
  }

  showAddParticipants() {
    this.setState({addParticipantsVisible: true});
  }

  removeMember(participant) {
    this.props.dispatch(
        CurrentOrganizationActions.removeMember(
            this.props.currentOrganization.organization.id,
            participant.id,
            'a38f8ef4-400b-4229-a5ff-712ff5f72b27'
        )
    );
  }

  addMember(participant) {
    this.props.dispatch(
      CurrentOrganizationActions.addMember(
        this.props.currentOrganization.organization.id,
          participant.id
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
