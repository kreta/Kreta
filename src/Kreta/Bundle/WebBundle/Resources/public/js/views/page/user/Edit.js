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

import ContentMiddleLayout from '../../layout/ContentMiddleLayout';
import Button from '../../component/Button.js';
import {FormSerializerService} from '../../../service/FormSerializer';
import {NotificationService} from '../../../service/Notification';
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
  save(ev) {
    ev.preventDefault();

    const user = FormSerializerService.serialize(
      $(this.refs.form), Profile
    );

    user.save(null, {
      success: () => {
        NotificationService.showNotification({
          type: 'success',
          message: 'Your profile was updated successfully'
        });
      }, error: () => {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while saving changes'
        });
      }
    });

    return false;
  },
  render() {
    const user = this.state.user.toJSON();

    return (
      <ContentMiddleLayout>
        <form className="user-edit" onSubmit={this.save} ref="form">
          <div>
            <input defaultValue={user.first_name}
                   name="firstName"
                   placeholder="First name"
                   type="text"/>
            <input defaultValue={user.last_name}
                   name="lastName"
                   placeholder="Last name"
                   type="text"/>
            <input defaultValue={user.username}
                   name="username"
                   placeholder="Username"
                   type="text"/>
            <img ref="previewImage" src={user.photo.name}/>
            <input defaultValue=""
                   name="photo"
                   onChange={this.onPhotoChange}
                   type="file"/>
          </div>
          <div className="spacer-vertical-1">
            <Button color="green" type="submit">Update</Button>
          </div>
        </form>
      </ContentMiddleLayout>
    );
  }
});
