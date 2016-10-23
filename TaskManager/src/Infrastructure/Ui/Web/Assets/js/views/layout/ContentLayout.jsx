/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/layout/_content';

import React from 'react';

class ContentLayout extends React.Component {
  render() {
    return (
      <div className="content">
        {this.props.children}
      </div>
    );
  }
}

export default ContentLayout;
