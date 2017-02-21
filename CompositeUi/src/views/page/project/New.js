/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/project/_new';

import React from 'react';
import {connect} from 'react-redux';

import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ProjectNew from './../../form/ProjectNew';

import CurrentOrganizationActions from './../../../actions/CurrentOrganization';
import ProjectsActions from './../../../actions/Projects';

@connect(state => ({currentOrganization: state.currentOrganization}))
class New extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentOrganizationActions.fetchOrganization(params.organization));
  }

  createProject(project) {
    const {dispatch, currentOrganization} = this.props;

    project.organization = currentOrganization.organization.id;
    dispatch(ProjectsActions.createProject(project));
  }

  render() {
    return (
      <ContentMiddleLayout centered>
        <ProjectNew onSubmit={this.createProject.bind(this)}/>
      </ContentMiddleLayout>
    );
  }
}

export default New;
