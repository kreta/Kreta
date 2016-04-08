/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/layout/_notification';

import React from 'react';
import { connect } from 'react-redux';

import Notification from './../component/Notification';
import NotificationActions from '../../actions/Notification';

class NotificationLayout extends React.Component {
  componentDidMount() {
    this.props.dispatch(NotificationActions.startNotificationCleaner());
  }

  removeNotification(notification) {
    this.props.dispatch(NotificationActions.removeNotification(notification));
  }

  render() {
    const notifications = this.props.notifications.map((notification, index) => {
      return (
        <Notification key={index}
                      notification={notification}
                      onCloseRequest={this.removeNotification.bind(this, notification)}/>
      );
    });

    return (
      <div className="notification-layout">
        {notifications}
      </div>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    notifications: state.notification.notifications
  };
};

export default connect(mapStateToProps)(NotificationLayout);
