/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../scss/layout/_base.scss';

import React from 'react';

import ContentLayout from './ContentLayout.js';
import MainMenu from './MainMenu.js';
import NotificationLayout from './NotificationLayout.js';

export default React.createClass({

  render() {
    return (
      <div className="base-layout">
        <NotificationLayout/>
        <MainMenu/>
        <ContentLayout>
          {this.props.children}
        </ContentLayout>
      </div>
    );
  }
});
