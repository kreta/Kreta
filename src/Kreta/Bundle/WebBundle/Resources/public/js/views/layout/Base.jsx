/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/layout/_base';

import React from 'react';
import { connect } from 'react-redux';

import ContentLayout from './ContentLayout';
import MainMenu from './MainMenu';
import NotificationLayout from './NotificationLayout';

import ProjectActions from '../../actions/Projects';
import ProfileActions from '../../actions/Profile';

class Base extends React.Component {
  componentDidMount() {
    const { dispatch } = this.props;
    dispatch(ProjectActions.fetchProjects());
    dispatch(ProfileActions.fetchProfile());
  }

  render() {
    return (
      <div className="base-layout">
        <NotificationLayout/>
        <MainMenu/>
        <ContentLayout>
          {this.props.children}
        </ContentLayout>
      </div>
    );
  }
}

const mapStateToProps = (state) => {
  return {};
};


export default connect(mapStateToProps)(Base);
