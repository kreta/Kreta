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

import CardExtended from './CardExtended';
import UserThumbnail from './UserThumbnail';

class UserCard extends React.Component {
  static propTypes = {
    user: React.PropTypes.object.isRequired,
  };

  username() {
    const {user} = this.props;

    return `@${user.user_name}`;
  }

  subtitle() {
    return this.title() === this.username() ? null : this.username();
  }

  title() {
    const {user} = this.props;

    if (user.first_name && user.last_name) {
      return `${user.first_name} ${user.last_name}`;
    }

    return this.username();
  }

  render() {
    const {user, actions} = this.props;

    return (
      <CardExtended
        subtitle={this.subtitle()}
        thumbnail={<UserThumbnail user={user} />}
        title={this.title()}
      >
        {actions}
      </CardExtended>
    );
  }
}

export default UserCard;
