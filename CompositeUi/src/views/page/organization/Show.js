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
import {Link} from 'react-router';
import React from 'react';

import {routes} from './../../../Routes';

import CurrentOrganizationActions from './../../../actions/CurrentOrganization';

import Button from './../../component/Button';
import CardExtended from './../../component/CardExtended';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import LoadingSpinner from './../../component/LoadingSpinner';
import Members from './../../composition/Members';
import PageHeader from './../../component/PageHeader';
import Section from './../../component/Section';
import SectionHeader from './../../component/SectionHeader';
import Thumbnail from './../../component/Thumbnail';
import {Row, RowColumn} from './../../component/Grid';

@connect(state => ({currentOrganization: state.currentOrganization, profile: state.profile.profile}))
class Show extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentOrganizationActions.fetchOrganization(params.organization));
  }

  getProjects() {
    const
      {currentOrganization} = this.props,
      organization = currentOrganization.organization;

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

  removeMember(member) {
    const
      {currentOrganization, dispatch} = this.props,
      organization = currentOrganization.organization;

    dispatch(
      CurrentOrganizationActions.removeMember(
        organization.id,
        member.id,
      )
    );
  }

  render() {
    const
      {currentOrganization, children, location, profile} = this.props,
      organization = currentOrganization.organization;

    if (currentOrganization.fetching) {
      return <LoadingSpinner/>;
    }

    return (
      <div>
        <ContentMiddleLayout>
          <Row>
            <RowColumn>
              <PageHeader thumbnail={<Thumbnail image={null} text={organization.name}/>} title={organization.name}>
                <Link to={routes.project.new(organization.slug)}>
                  <Button color="green">New project</Button>
                </Link>
              </PageHeader>
            </RowColumn>
            <RowColumn>
              <Section header={<SectionHeader title="Projects"/>}>
                {this.getProjects()}
              </Section>
            </RowColumn>
            <RowColumn>
              <Members
                currentPath={location.pathname}
                organization={organization}
                profile={profile}
                removeMember={this.removeMember.bind(this)}
              />
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
