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
import ProjectPreview from './../../component/ProjectPreview';
import Warning from './../../component/Warning';

export default class Show extends React.Component {
  getOrganizationProjects() {
    if (this.props.organization.organization.projects.length > 0) {
      return this.props.organization.organization.projects.map((project, index) => {
        project.organization = this.props.organization.organization;

        return <ProjectPreview key={index} project={project} />
      });
    }

    return <Warning text="This organization does not have any project created yet"/>
  }

  render() {
    if (this.props.organization.fetchingOrganization) {
      return <LoadingSpinner/>;
    }
    return (
      <ContentMiddleLayout>
        <div className="index__dashboard">
          <DashboardWidget title={`${this.props.organization.organization.name} projects`}>
            {this.getOrganizationProjects()}
          </DashboardWidget>
          <DashboardWidget title="Need more projects?">
            <Warning text="You can create a new one pressing the button bellow">
              <Link to={`/${this.props.organization.organization.slug}/project/new`}>
                <Button color="green">Create project</Button>
              </Link>
            </Warning>
          </DashboardWidget>
        </div>
      </ContentMiddleLayout>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    organization: state.currentOrganization
  };
};

export default connect(mapStateToProps)(Show);
