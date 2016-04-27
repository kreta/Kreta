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

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import DashboardWidget from './../../component/DashboardWidget';
import LoadingSpinner from './../../component/LoadingSpinner';
import PageHeader from './../../component/PageHeader';
import ProjectPreview from './../../component/ProjectPreview';
import UserPreview from './../../component/UserPreview';
import Warning from './../../component/Warning';

export default class Show extends React.Component {
  getProjects() {
    if (this.props.organization.projects.length > 0) {
      return this.props.organization.projects.map((project, index) => {
        project.organization = this.props.organization;

        return <ProjectPreview key={index} project={project} />
      });
    }

    return <Warning text="This organization does not have any project created yet">
      <Link to={`/${this.props.organization.slug}/project/new`}>
        <Button color="green">Create project</Button>
      </Link>
    </Warning>;
  }

  getParticipants() {
    if (this.props.organization.participants.length > 0) {
      return this.props.organization.participants.map((participant, index) => {
        return <UserPreview key={index} user={participant.user} />
      });
    }
  }

  render() {
    if (this.props.isFetching) {
      return <LoadingSpinner/>;
    }

    let buttons = [{
      href: `/${this.props.organization.slug}/project/new`,
      title: 'Create project'
    }];

    return (
      <ContentMiddleLayout>
        <PageHeader buttons={buttons}
                    image={this.props.organization.image ? this.props.organization.image.name : ''}
                    title={this.props.organization.name}/>
        <div className="index__dashboard">
          <DashboardWidget title="Projects">
            {this.getProjects()}
          </DashboardWidget>
          <DashboardWidget title="Participants">
            {this.getParticipants()}
          </DashboardWidget>
        </div>
      </ContentMiddleLayout>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    organization: state.currentOrganization.organization,
    isFetching: state.currentOrganization.fetchingOrganization
  };
};

export default connect(mapStateToProps)(Show);
