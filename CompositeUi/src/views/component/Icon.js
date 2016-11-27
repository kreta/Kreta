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
import classNames from 'classnames';

import './../../scss/components/_icon';

class Icon extends React.Component {
  static propTypes = {
    glyph: React.PropTypes.string.isRequired
  };

  static defaultProps = {
    className: ''
  };

  render() {
    const {glyph, color, size, className, ...props} = this.props,
      classes = classNames({
        'icon': true,
        'icon--expand': size === 'expand',
        'icon--small': size === 'small',
        'icon--blue': color === 'blue',
        'icon--red': color === 'red',
        'icon--white': color === 'white',
      });

    return (
      <svg {...props} className={`${classes} ${className}`}>
        <use xlinkHref={glyph}/>
      </svg>
    );
  }
}

export default Icon;
