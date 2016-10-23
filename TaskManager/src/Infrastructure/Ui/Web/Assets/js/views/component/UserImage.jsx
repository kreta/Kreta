/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_user-image';

import React from 'react';

class UserImage extends React.Component {
  static propTypes = {
    user: React.PropTypes.object.isRequired
  };

  render() {
    if (this.props.user.photo) {
      return (
        <img className="user-image" src={this.props.user.photo.name}/>
      );
    }

    let resultChar = '';
    if (this.props.user.first_name && this.props.user.last_name &&
      this.props.user.first_name.length > 0 && this.props.user.last_name.length > 0) {
      resultChar = `${this.props.user.first_name.charAt(0)}${this.props.user.last_name.charAt(0)}`;
    } else {
      resultChar = this.props.user.username.substring(0, 2);
    }

    return (
      <div className="user-image user-image--has-char">
        <span className="user-image__char">{resultChar.toUpperCase()}</span>
      </div>
    );
  }
}

export default UserImage;
