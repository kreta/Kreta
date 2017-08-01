/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_dashboard-widget.scss';

import React from 'react';

const DashboardWidget = props => (
  <div className="dashboard-widget">
    {props.children}
  </div>
);

export default DashboardWidget;
