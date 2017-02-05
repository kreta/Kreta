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
import ResetPassword from './../form/ResetPassword';
import LogoCustomHeader from './../component/LogoCustomHeader';
// import UserActions from './../../actions/User';

@connect()
class ResetPasswordPage extends React.Component {
  resetPassword() {
//     this.props.dispatch(UserActions.resetPassword(email));
  }

  render() {
    return (
      <div>
        <NotificationLayout/>
        <ContentLayout>
          <ContentMiddleLayout>
            <LogoCustomHeader title="Reset your password"/>
            <ResetPassword onSubmit={this.resetPassword.bind(this)}/>
          </ContentMiddleLayout>
        </ContentLayout>
      </div>
    );
  }
}

export default ResetPasswordPage;
