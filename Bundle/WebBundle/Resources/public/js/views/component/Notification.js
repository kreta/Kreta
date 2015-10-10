/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/components/_notification.scss';

import classnames from 'classnames';
import React from 'react';

export default React.createClass({
  render() {
    const classes = classnames({
      'notification': true,
      'notification--visible': this.state.notification !== null
    });

    return (
      <div className={classes}>
        <div className="notification-icon">
          <i className="fa fa-exclamation-circle"></i>
        </div>
        <p className="notification-message">{this.props.message}</p>
        <i className="notification-hide fa fa-times"
           onClick={this.props.onCloseClick}></i>
      </div>
    );
  }
});
