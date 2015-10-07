/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';

import MainMenu from './mainMenu.js';

export default React.createClass({
  render() {
    return (
      <div>
        <MainMenu/>
        <div id="kreta-content">
          <div>
            <div className="notification-container"></div>
            <div className="kreta-content-container">
              {this.props.children || 'Welcome'}
            </div>
          </div>
        </div>
      </div>
    );
  }
});
