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

import Thumbnail from './Thumbnail';

class UserThumbnail extends React.Component {
  static propTypes = {
    user: React.PropTypes.object.isRequired
  };

  image() {
    const {user} = this.props;

    return user.image ? user.image : null;
  }

  text() {
    const {user} = this.props;

    if (user.first_name && user.last_name) {
      return `${user.first_name} ${user.last_name}`;
    }

    return user.email;
  }

  render() {
    return (
      <Thumbnail image={this.image()} text={this.text()}/>
    );
  }
}

export default UserThumbnail;
