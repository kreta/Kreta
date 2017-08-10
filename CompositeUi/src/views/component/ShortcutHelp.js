/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_shortcut-help.scss';

import React from 'react';

export default props =>
  <div className="shortcut-help">
    <span className="shortcut-help__keyboard">
      {props.keyboard}
    </span>
    {props.does}
  </div>;
