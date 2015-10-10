/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';

import App from '../../App';

export default React.createClass({
  componentDidMount() {
    App.collection.notifications.on('add', this.updateNotifications);
    App.collection.notifications.on('remove', this.updateNotifications);
  },
  updateNotifications(notifications) {
    this.setState({
      notifications
    });
  },
  render() {
    const notifications = App.collection.notifications.map((notification) => {
      return (
        <Notification notification={this.state.notification}/>
      );
    });

    return (
      <div className="notification-layout">
        {notifications}
      </div>
    );
  }
});
