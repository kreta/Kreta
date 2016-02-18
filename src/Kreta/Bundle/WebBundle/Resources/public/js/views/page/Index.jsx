/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/_index';

import React from 'react';
import {Link} from 'react-router'
import { connect } from 'react-redux';

import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import Button from './../component/Button';
import DashboardWidget from './../component/DashboardWidget';
import Warning from './../component/Warning';
import LoadingSpinner from './../component/LoadingSpinner';
import ProjectPreview from './../component/ProjectPreview';

import OrganizationActions from '../../actions/Organizations';

class Index extends React.Component {
  componentDidMount() {
    this.props.dispatch(OrganizationActions.fetchOrganizations());
  }

  getOrganizationItems() {
    if (this.props.organizations.fetching) {
      return <LoadingSpinner/>;
    }

    if (this.props.organizations.organizations.length > 0) {
      return this.props.organizations.organizations.map((organization, index) => {
        return <Link to={`/${organization.slug}`} key={index}>{organization.name}</Link>
      });
    }

    return <Warning text="No organizations found, create one or ask an invite for an existing one">
      <Link to="/organization/new"><Button color='green'>Create organization</Button></Link>
    </Warning>;
  }

  getProjectsItems() {
    if (this.props.projects.fetching) {
      return <LoadingSpinner/>;
    }

    if (this.props.projects.projects.length > 0) {
      return this.props.projects.projects.map((project, index) => {
        return <ProjectPreview key={index}
                               project={project}/>;
      });
    }

    return <Warning text="No projects found, you may want to create one">
        <Link to="/project/new"><Button color='green'>Create project</Button></Link>
      </Warning>;
  }

  render() {
    return (
      <ContentMiddleLayout>
        <div className="index__dashboard">
          <DashboardWidget title="Your organizations">
            { this.getOrganizationItems() }
          </DashboardWidget>
          <DashboardWidget title="Your projects">
            { this.getProjectsItems() }
          </DashboardWidget>
        </div>
      </ContentMiddleLayout>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    projects: state.projects,
    organizations: state.organizations
  };
};

export default connect(mapStateToProps)(Index);

