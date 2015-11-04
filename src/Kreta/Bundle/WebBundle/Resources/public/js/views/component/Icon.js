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

export default React.createClass({
  propTypes: {
    className: React.PropTypes.string,
    glyph: React.PropTypes.string.isRequired
  },
  getDefaultProps() {
    return {
      className: 'icon'
    };
  },
  render() {
    var { glyph, ...props} = this.props;
    return (
      <svg {...props}>
        <use xlinkHref={glyph}/>
      </svg>
    );
  }
});
