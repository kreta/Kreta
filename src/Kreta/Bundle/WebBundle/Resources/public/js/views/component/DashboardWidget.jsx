/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_dashboard-widget';

import React from 'react';

class DashboardWidget extends React.Component {
  static propTypes = {
    title: React.PropTypes.string.isRequired
  };

  render() {
    return (
      <div className="dashboard-widget">
        <h3 className="dashboard-widget__header">{this.props.title}</h3>
        <div className="dashboard-widget__content">
          {this.props.children}
        </div>
      </div>
    );
  }
}

export default DashboardWidget;
