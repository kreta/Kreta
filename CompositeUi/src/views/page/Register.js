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

import UserActions from './../../actions/User';

import ContentLayout from './../layout/ContentLayout';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import LogoCustomHeader from './../component/LogoCustomHeader';
import NotificationLayout from './../layout/NotificationLayout';
import Register from './../form/Register';

@connect()
class RegisterPage extends React.Component {
  register(credentials) {
    this.props.dispatch(UserActions.register(credentials));
  }

  render() {
    return (
      <div>
        <NotificationLayout />
        <ContentLayout>
          <ContentMiddleLayout centered>
            <LogoCustomHeader title="Join Kreta" />
            <Register onSubmit={this.register.bind(this)} />
          </ContentMiddleLayout>
        </ContentLayout>
      </div>
    );
  }
}

export default RegisterPage;
