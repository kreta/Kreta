/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import SettingsIcon from './../../../svg/settings.svg';
import CrossIcon from './../../../svg/cross.svg';

import {connect} from 'react-redux';
import {Link} from 'react-router';
import React from 'react';

import {routes} from './../../../Routes';

import CurrentOrganizationActions from './../../../actions/CurrentOrganization';

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
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentOrganizationActions.fetchOrganization(params.organization));
  }

  getProjects() {
    const {organization} = this.props.currentOrganization;

    return organization._projects2TvKxM.edges.map((project, index) => {
      const currentProject = project.node;

      return (
        <Link key={index} to={routes.project.show(organization.slug, currentProject.slug)}>
          <CardExtended
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
          >
            <Icon color="white" glyph={CrossIcon} size="expand"/>
          </Button>
        }
        key={index}
        user={member}
      />
    ));
  }

  removeMember(member) {
    const {currentOrganization, dispatch} = this.props;

    dispatch(
      CurrentOrganizationActions.removeMember(
        currentOrganization.organization.id,
        member.id,
      )
    );
  }

  render() {
    const {currentOrganization, children} = this.props;

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
                <InlineLink to={routes.organization.settings(currentOrganization.organization.slug)}>
                  <Icon color="green" glyph={SettingsIcon} size="small"/>Settings
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
                title="Owners"
              />
              {this.getOwners()}
              <SectionHeader
                actions={
                  <Link to={routes.organization.addMember(currentOrganization.organization.slug)}>
                    <Button color="green">Add Members</Button>
                  </Link>
                }
                title="Members"/>
              {this.getMembers()}
            </RowColumn>
          </Row>
        </ContentMiddleLayout>
        <ContentRightLayout isOpen={children !== null}>
          {children}
        </ContentRightLayout>
      </div>
    );
  }
}

export default Show;
