/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';

import './../../scss/components/_section-header.scss';

const SectionHeader = props => (
  <div className="section__header">
    <h3 className="section__header-title">
      {props.title}
    </h3>
    <div className="section__header-actions">
      {props.actions}
    </div>
  </div>
);

export default SectionHeader;
