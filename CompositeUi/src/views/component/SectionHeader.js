/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_section-header.scss';

import React from 'react';

const SectionHeader = props => (
  <div className="section-header">
    <h3 className="section-header__title">
      {props.title}
    </h3>
    <div className="section-header__actions">
      {props.actions}
    </div>
  </div>
);

export default SectionHeader;
