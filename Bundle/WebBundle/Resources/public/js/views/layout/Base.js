/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';

import ContentLayout from './ContentLayout.js';
import MainMenu from './MainMenu.js';
import NotificationLayout from './NotificationLayout.js';

export default React.createClass({

  render() {
    return (
      <div>
        <NotificationLayout/>
        <MainMenu/>
        <ContentLayout>
          {this.props.children}
        </ContentLayout>
      </div>
    );
  }
});
