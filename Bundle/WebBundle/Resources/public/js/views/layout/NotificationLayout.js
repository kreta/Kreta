/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';

import Notification from '../component/Notification.js';

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
  updateNotifications() {
    this.setState({
      notifications: App.collection.notification.models
    });
  },
  render() {
    const notifications = this.state.notifications.map((notification, index) => {
      return (
        <Notification message={notification.get('message')}
                      key={index}
                      type={notification.get('type')}
                      value={index}/>
      );
    });

    return (
      <div className="notification-layout">
        {notifications}
      </div>
    );
  }
});
