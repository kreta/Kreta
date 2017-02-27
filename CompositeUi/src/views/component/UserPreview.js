/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_user-preview';

import React from 'react';


class UserPreview extends React.Component {
  render() {
    const user = this.props.user;

    return (
      <div className="user-preview">
        <div className="user-preview__image">
        </div>

        <div className="user-preview__container">
              <span className="user-preview__header">
                  {user.first_name ? user.first_name : 'undefined'} {user.last_name ? user.last_name : 'undefined' }
              </span>
          <span className="user-preview__subheader">
            @{user.user_name ? user.user_name : 'undefined' }
          </span>
        </div>
        <div className="user-preview__actions">
          {this.props.actions}
        </div>
      </div>
    );
  }
}

export default UserPreview;
