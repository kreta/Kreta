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
import LoadingSpinner from './../component/LoadingSpinner';
import Register from './../form/Register';
import LogoCustomHeader from './../component/LogoCustomHeader';
// import UserActions from './../../actions/User';

@connect(state => ({authorizing: state.user.updatingAuthorization}))
class RegisterPage extends React.Component {
  register() {
//     this.props.dispatch(UserActions.login(credentials));
  }

  render() {
    if (this.props.authorizing) {
      return <LoadingSpinner/>;
    }

    return (
      <div>
        <NotificationLayout/>
        <ContentLayout>
          <ContentMiddleLayout>
            <LogoCustomHeader title="Join Kreta"/>
            <Register onSubmit={this.register.bind(this)}/>
          </ContentMiddleLayout>
        </ContentLayout>
      </div>
    );
  }
}

export default RegisterPage;
