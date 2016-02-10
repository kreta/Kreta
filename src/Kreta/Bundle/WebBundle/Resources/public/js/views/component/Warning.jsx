/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_warning';

import React from 'react';

class DashboardWidgetWarning extends React.Component {
  static propTypes = {
    text: React.PropTypes.string.isRequired
  };

  render() {
    return (
      <div className="warning">
        <p className="warning__text">{this.props.text}</p>
        <div className="warning__content">
          {this.props.children}
        </div>
      </div>
    );
  }
}

export default DashboardWidgetWarning;
