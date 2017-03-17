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

import CurrentOrganizationActions from './../../../actions/CurrentOrganization';

import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ProjectEdit from './../../form/ProjectEdit';

@connect(state => ({currentProject: state.currentProject}))
class Settings extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentOrganizationActions.fetchOrganization(params.organization));
  }

//   editProject() {
//     const
//       {dispatch, currentProject} = this.props,
//       id = currentProject.id;
//
//     dispatch(CurrentProjectActions.updateTask({...updatedTask, id}));
//   }

  editProject(project) {
    const {dispatch, currentOrganization} = this.props;

    project.organization = currentOrganization.organization.id;
    dispatch(CurrentOrganizationActions.createProject(project));
  }

  render() {
    return (
      <ContentMiddleLayout centered>
        <ProjectEdit onSubmit={this.editProject.bind(this)}/>
      </ContentMiddleLayout>
    );
  }
}

export default Settings;
