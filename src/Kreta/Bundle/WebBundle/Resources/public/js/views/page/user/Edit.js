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
import $ from 'jquery';

import Button from '../../component/Button.js';
import ContentMiddleLayout from '../../layout/ContentMiddleLayout';
import Form from '../../component/Form.js';
import FormInput from '../../component/FormInput.js';
import {Profile} from '../../../models/Profile';

export default React.createClass({
  componentWillMount() {
    this.originalImage = App.currentUser.get('photo');
    this.setState({
      user: App.currentUser
    });
  },
  onPhotoChange(ev) {
    var file = $(ev.currentTarget)[0].files[0];
    if (typeof file === 'undefined') {
      this.refs.previewImage.src = this.originalImage;
    } else {
      this.refs.previewImage.src = window.URL.createObjectURL(file);
    }
  },
  showErrors(errors) {
    console.log(errors);
  },
  render() {
    const user = this.state.user.toJSON();

    return (
      <ContentMiddleLayout>
        <Form model={Profile}
              onSaveError={this.showErrors}>
          <FormInput name="firstName"
                     label="First Name"
                     tabIndex={2}
                     type="text"
                     value={user.first_name}/>
          <FormInput name="lastName"
                     label="Last Name"
                     tabIndex={3}
                     type="text"
                     value={user.last_name}/>
          <FormInput name="username"
                     label="Username"
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
});
