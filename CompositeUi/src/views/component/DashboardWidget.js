/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_dashboard-widget';

import React from 'react';

import SectionHeader from './SectionHeader';

class DashboardWidget extends React.Component {
  static propTypes = {
    actions: React.PropTypes.element,
    title: React.PropTypes.oneOfType([
      React.PropTypes.string,
      React.PropTypes.element,
    ])
  };

  render() {
    const {title, children, actions, ...otherProps} = this.props;

    return (
      <div className="dashboard-widget" {...otherProps}>
        <SectionHeader actions={actions} title={title}/>
        {children}
      </div>
    );
  }
}

export default DashboardWidget;
