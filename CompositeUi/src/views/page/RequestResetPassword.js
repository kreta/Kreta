/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';
import {connect} from 'react-redux';

import ContentLayout from './../layout/ContentLayout';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import NotificationLayout from './../layout/NotificationLayout';
import RequestResetPassword from './../form/RequestResetPassword';
import LogoCustomHeader from './../component/LogoCustomHeader';
import UserActions from './../../actions/User';

@connect()
class ResetPasswordPage extends React.Component {
  requestResetPassword(email) {
    this.props.dispatch(UserActions.requestResetPassword(email));
  }

  render() {
    return (
      <div>
        <NotificationLayout/>
        <ContentLayout>
          <ContentMiddleLayout centered>
            <LogoCustomHeader title="Reset your password"/>
            <RequestResetPassword onSubmit={this.requestResetPassword.bind(this)}/>
          </ContentMiddleLayout>
        </ContentLayout>
      </div>
    );
  }
}

export default ResetPasswordPage;
