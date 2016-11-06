/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/_index';

import React from 'react';

class ProtectedArea extends React.Component {
  render() {
    return (
      <div>
        {this.props.children}
      </div>
    )
  }
}

export default ProtectedArea;
