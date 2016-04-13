/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_notification';

import classnames from 'classnames';
import React from 'react';

class Notification extends React.Component {
  static propTypes = {
    notification: React.PropTypes.object.isRequired,
    onCloseRequest: React.PropTypes.func
  };

  triggerOnCloseRequest() {
    this.props.onCloseRequest();
  }

  render() {
    const classes = classnames({
      'notification': true,
      'notification--visible': true,
      'notification--error': this.props.notification.type === 'error'
    });

    return (
      <div className={classes}>
        <div className="notification__icon">
          <i className="fa fa-exclamation-circle"></i>
        </div>
        <p className="notification__message">{this.props.notification.message}</p>
        <i className="notification__hide fa fa-times"
           onClick={this.triggerOnCloseRequest.bind(this)}></i>
      </div>
    );
  }
}

export default Notification;
