/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/components/_button.scss';

import React from 'react';
import classnames from 'classnames';

export default React.createClass({
  propTypes: {
    color: React.PropTypes.string,
    onClick: React.PropTypes.func,
    size: React.PropTypes.string,
    type: React.PropTypes.string
  },
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
})
