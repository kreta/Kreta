/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_help-text.scss';

import React from 'react';

const HelpText = props =>
  <p className={`help-text${props.center ? ' help-text--center' : ''}`}>
    {props.children}
  </p>;

export default HelpText;
