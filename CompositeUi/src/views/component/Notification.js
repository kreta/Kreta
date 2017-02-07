/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_notification';
import Close from './../../svg/notification-close.svg';
import Error from './../../svg/notification-error.svg';
import Success from './../../svg/notification-sucess.svg';

import classnames from 'classnames';
import React from 'react';

import Icon from './Icon';

class Notification extends React.Component {
  static propTypes = {
    notification: React.PropTypes.object.isRequired,
    onCloseRequest: React.PropTypes.func
  };

  triggerOnCloseRequest() {
    this.props.onCloseRequest();
  }

  render() {
    const
      {notification} = this.props,
      classes = classnames({
        'notification': true,
        'notification--visible': true,
        'notification--error': notification.type === 'error'
      }),
      glyph = notification.type === 'error' ? Error : Success;

    return (
      <div className={classes}>
        <div className="notification__icon">
          <Icon glyph={glyph}/>
        </div>
        <p className="notification__message">{notification.message}</p>
        <Icon
          className="notification__close"
          glyph={Close}
          onClick={this.triggerOnCloseRequest.bind(this)}
        />
      </div>
    );
  }
}

export default Notification;
