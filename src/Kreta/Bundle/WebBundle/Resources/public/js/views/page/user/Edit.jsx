/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import $ from 'jquery';
import React from 'react';

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import Form from './../../component/Form';
import FormInput from './../../component/FormInput';
import Profile from './../../../models/Profile';

class Edit extends React.Component {
  componentWillMount() {
    this.originalImage = App.currentUser.get('photo');
    this.setState({
      user: App.currentUser
    });
  }

  onPhotoChange(ev) {
    var file = $(ev.currentTarget)[0].files[0];
    if (typeof file === 'undefined') {
      this.refs.previewImage.src = this.originalImage;
    } else {
      this.refs.previewImage.src = window.URL.createObjectURL(file);
    }
  }

  render() {
    const user = this.state.user.toJSON();

    return (
      <ContentMiddleLayout>
        <Form model={Profile}>
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
                     tabIndex={3}
                     type="text"
                     value={user.username}/>
          <img ref="previewImage" src={user.photo ? user.photo.name : ''}/>
          <input defaultValue=""
                 name="photo"
                 onChange={this.onPhotoChange}
                 type="file"/>
          <div className="issue-new__actions">
            <Button color="green" type="submit">Update</Button>
          </div>
        </Form>
      </ContentMiddleLayout>
    );
  }
}

export default Edit;
