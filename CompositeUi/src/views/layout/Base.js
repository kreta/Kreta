/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/layout/_base';

import {connect} from 'react-redux';
import React from 'react';

import ProfileActions from './../../actions/Profile';
import ProjectsActions from './../../actions/Projects';

import ContentLayout from './ContentLayout';
import LoadingSpinner from './../component/LoadingSpinner';
import MainMenu from './MainMenu';
import NotificationLayout from './NotificationLayout';

@connect(state => ({
  waiting: state.projects.fetching || state.profile.fetching || state.user.updatingAuthorization,
  profile: state.profile.profile
}))
class Base extends React.Component {
  componentDidMount() {
    const {dispatch} = this.props;

    dispatch(ProfileActions.fetchProfile());
    dispatch(ProjectsActions.fetchProjects());
  }

  render() {
    const {children, profile, waiting} = this.props;

    if (true === waiting || null === profile) {
      return <LoadingSpinner/>;
    }

    return (
      <div className="base-layout">
        <NotificationLayout/>
        <MainMenu/>
        <ContentLayout>
          {children}
        </ContentLayout>
      </div>
    );
  }
}

export default Base;
