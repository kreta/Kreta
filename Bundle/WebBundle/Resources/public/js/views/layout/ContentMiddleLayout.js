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
import classnames from 'classnames';

export default React.createClass({
  propTypes: {
    rightOpen: React.PropTypes.bool
  },
  getDefaultProps() {
    return {
      rightOpen: false
    };
  },
  render() {
    const classes = classnames({
      'content__middle': true,
      'content__middle--right-open': this.props.rightOpen
    });

    return (
      <div className={classes}>
        {this.props.children}
      </div>
    );
  }
});
