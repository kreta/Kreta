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
import LoadingSpinner from './../../component/LoadingSpinner';
import ProjectEdit from './../../form/ProjectEdit';

@connect(state => ({currentProject: state.currentProject.project}))
class Settings extends React.Component {
  editProject(project) {
    const {dispatch, currentProject} = this.props,
      id = currentProject.id;

    dispatch(CurrentOrganizationActions.editProject({...project, id}));
  }

  render() {
    const {currentProject} = this.props;

    if (!currentProject) {
      return <LoadingSpinner />;
    }

    return (
      <ContentMiddleLayout centered>
        <ProjectEdit onSubmit={this.editProject.bind(this)} />
      </ContentMiddleLayout>
    );
  }
}

export default Settings;
