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
import {routeActions} from 'react-router-redux';

import UserActions from './../../actions/User';

import {routes} from './../../Routes';

import ContentLayout from './../layout/ContentLayout';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import LogoCustomHeader from './../component/LogoCustomHeader';
import NotificationLayout from './../layout/NotificationLayout';
import ResetPassword from './../form/ResetPassword';

@connect()
class ResetPasswordPage extends React.Component {
  componentDidMount() {
    const {dispatch, location} = this.props,
      token = location.query['remember-password-token'];

    if (typeof token === 'undefined' || token.length === 0) {
      dispatch(routeActions.push(routes.requestResetPassword));
    }
  }

  resetPassword(passwords) {
    const {location} = this.props,
      token = location.query['remember-password-token'];

    this.props.dispatch(
      UserActions.changePassword({
        token,
        passwords,
      }),
    );
  }

  render() {
    return (
      <div>
        <NotificationLayout />
        <ContentLayout>
          <ContentMiddleLayout centered>
            <LogoCustomHeader title="Reset your password" />
            <ResetPassword onSubmit={this.resetPassword.bind(this)} />
          </ContentMiddleLayout>
        </ContentLayout>
      </div>
    );
  }
}

export default ResetPasswordPage;
