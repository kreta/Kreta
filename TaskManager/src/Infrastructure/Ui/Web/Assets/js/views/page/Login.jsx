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

import LogoFullIcon from './../../../svg/logo-full';

import Button from './../component/Button';
import FormInput from './../component/FormInput';
import Icon from './../component/Icon';

import ContentLayout from './../layout/ContentLayout';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';

class Login extends React.Component {
  login() {
    console.log('Login tried');
  }

  render() {
    return (
      <ContentLayout>
        <ContentMiddleLayout>
          <div style={{'text-align': 'center'}}>
            <Icon glyph={LogoFullIcon}/>
          </div>
          <form onSubmit={this.login.bind(this)}>
            <FormInput autoFocus
                       label="Username"
                       name="username"
                       tabIndex={1}
                       value=""/>
            <FormInput label="Password"
                       name="password"
                       tabIndex={2}
                       type="password"
                       value=""/>
            <div className="issue-new__actions">
              <Button color="green" tabIndex="3" type="submit">Login</Button>
            </div>
          </form>
        </ContentMiddleLayout>
      </ContentLayout>
    );
  }
}

export default Login;
