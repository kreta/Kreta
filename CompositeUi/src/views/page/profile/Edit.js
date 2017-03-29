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

import ProfileActions from './../../../actions/Profile';

import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ProfileEdit from './../../form/ProfileEdit';

@connect()
class Edit extends React.Component {
  updateProfile(profile) {
    this.props.dispatch(ProfileActions.updateProfile(profile));
  }

  render() {
    return (
      <ContentMiddleLayout centered>
        <ProfileEdit onSubmit={this.updateProfile.bind(this)}/>
      </ContentMiddleLayout>
    );
  }
}

export default Edit;
