/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/components/_user-preview.scss';

import React from 'react';

export default React.createClass({
  render() {
    const user = this.props.user;

    return (
      <div className="user-preview">
        <img className="user-preview__image user-image"
             src={user.photo.name}/>

        <div className="user-preview__container">
              <span className="user-preview__header">
                  {user.first_name} {user.last_name}
              </span>
          <span className="user-preview__subheader">@{user.username}</span>
        </div>
        <div className="user-preview__actions">
          {this.props.actions}
        </div>
      </div>
    );
  }
});
