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

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import Form from './../../component/Form';
import FormInput from './../../component/FormInput';
import FormInputFile from './../../component/FormInputFile';
import Profile from './../../../models/Profile';
import {saveProfile} from './../../../actions/AppActions';

class Edit extends React.Component {
  componentWillMount() {
    this.originalImage = App.currentUser.get('photo');
    this.setState({
      user: App.currentUser
    });
  }

  _save() {
    saveProfile(this.state.user);
  }

  render() {
    const user = this.state.user.toJSON();

    return (
      <ContentMiddleLayout>
        <Form model={Profile}>
          <FormInputFile filename={user.photo ? user.photo.name : ''}
                         name="photo"
                         value=""/>
          <FormInput label="First Name"
                     name="firstName"
                     tabIndex={2}
                     type="text"
                     value={user.first_name}/>
          <FormInput label="Last Name"
                     name="lastName"
                     tabIndex={3}
                     type="text"
                     value={user.last_name}/>
          <FormInput label="Username"
                     name="username"
                     tabIndex={4}
                     type="text"
                     value={user.username}/>

          <div className="issue-new__actions">
            <Button color="green" onClick={this._save} type="submit">Update</Button>
          </div>
        </Form>
      </ContentMiddleLayout>
    );
  }
}

export default Edit;
