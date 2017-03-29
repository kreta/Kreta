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
import ProjectNew from './../../form/ProjectNew';
import LoadingSpinner from './../../component/LoadingSpinner';

@connect(state => ({currentOrganization: state.currentOrganization}))
class New extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentOrganizationActions.fetchOrganization(params.organization));
  }

  createProject(project) {
    const {dispatch, currentOrganization} = this.props;

    project.organization = currentOrganization.organization.id;
    dispatch(CurrentOrganizationActions.createProject(project));
  }

  render() {
    const {currentOrganization} = this.props;

    if (!currentOrganization.organization) {
      return <LoadingSpinner/>;
    }

    return (
      <ContentMiddleLayout centered>
        <ProjectNew onSubmit={this.createProject.bind(this)}/>
      </ContentMiddleLayout>
    );
  }
}

export default New;
