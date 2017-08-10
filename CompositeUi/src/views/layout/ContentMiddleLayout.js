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

const ContentMiddleLayout = props =>
  <div className="content__middle">
    <div
      className={`content__middle-content${props.centered
        ? ' content__middle-content--centered'
        : ''}`}
    >
      {props.children}
    </div>
  </div>;

export default ContentMiddleLayout;
