/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';

export default React.createClass({
  getInitialState() {
    return {
      notifications: []
    }
  },
  componentDidMount() {
    App.collection.notification.on('add', this.updateNotifications);
    App.collection.notification.on('remove', this.updateNotifications);
  },
  updateNotifications(notifications) {
    this.setState({
      notifications
    });
  },
  render() {
    const notifications = this.state.notifications.map((notification) => {
      return (
        <Notification notification={notification}/>
      );
    });

    return (
      <div className="notification-layout">
        {notifications}
      </div>
    );
  }
});
