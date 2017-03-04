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
import {Link} from 'react-router';

class NavigableListItemLink extends React.Component {
  defaultProps = {
    selected: false
  };

  render() {
    const {children, selected, to} = this.props;

    return (
      <Link className={`navigable-list-item-link ${selected ? ' navigable-list-item-link--selected' : ''}`}
            to={to}>
        {children}
      </Link>
    );
  }
}

export default NavigableListItemLink;
