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
    onClick: React.PropTypes.func,
    size: React.PropTypes.string,
    type: React.PropTypes.string
  };

  render() {
    const classes = classnames(
      'button',
      {
        'button--green': this.props.color === 'green',
        'button--icon': this.props.type === 'icon',
        'button--small': this.props.size === 'small'
      }
    );

    return (
      <button className={classes} {...this.props}>
        {this.props.children}
      </button>
    );
  }
}

export default Button;
