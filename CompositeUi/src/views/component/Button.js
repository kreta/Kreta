/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_button.scss';

import classnames from 'classnames';
import React from 'react';

class Button extends React.Component {
  static propTypes = {
    color: React.PropTypes.string,
    size: React.PropTypes.string,
    type: React.PropTypes.string,
  };

  render() {
    const {color, size, type} = this.props,
      classes = classnames('button', {
        'button--green': color === 'green',
        'button--red': color === 'red',
        'button--yellow': color === 'yellow',
        'button--blue': color === 'blue',
        'button--icon': type === 'icon',
        'button--small': size === 'small',
      });

    return (
      <button className={classes} {...this.props}>
        {this.props.children}
      </button>
    );
  }
}

export default Button;
