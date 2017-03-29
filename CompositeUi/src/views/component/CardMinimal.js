/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_card-minimal.scss';

import React from 'react';
import {Link} from 'react-router';

class CardMinimal extends React.Component {
  static propTypes = {
    title: React.PropTypes.string.isRequired,
    to: React.PropTypes.string.isRequired
  };

  render() {
    const {children, title, to} = this.props;

    return (
      <div className="card-minimal">
        <Link className="card-minimal__title"
              to={to}>
          {title}
        </Link>

        <div className="card-minimal__actions">
          {children}
        </div>
      </div>
    );
  }
}

export default CardMinimal;
