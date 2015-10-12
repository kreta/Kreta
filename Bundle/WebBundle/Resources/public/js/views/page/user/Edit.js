/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';
import $ from 'jquery';

import {FormSerializerService} from '../../../service/FormSerializer';
import {NotificationService} from '../../../service/Notification';
import {Profile} from '../../../models/Profile';
import ContentMiddleLayout from '../../layout/ContentMiddleLayout.js'

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
        <form className="user-edit" ref="form" onSubmit={this.save}>
          <div>
            <input name="firstName"
                   placeholder="First name"
                   type="text"
                   defaultValue={user.first_name}/>
            <input name="lastName"
                   placeholder="Last name"
                   type="text"
                   defaultValue={user.last_name}/>
            <input name="username"
                   placeholder="Username"
                   type="text"
                   defaultValue={user.username}/>
            <img ref="previewImage" src={user.photo.name}/>
            <input name="photo"
                   onChange={this.onPhotoChange}
                   type="file"
                   defaultValue="" />
          </div>
          <div className="spacer-vertical-1">
            <button className="button green" type="submit">Update</button>
          </div>
        </form>
      </ContentMiddleLayout>
    );
  }
});
