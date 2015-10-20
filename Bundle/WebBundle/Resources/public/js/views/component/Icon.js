/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
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
    return (
      <svg className={this.props.className}>
        <use xlinkHref={this.props.glyph}/>
      </svg>
    );
  }
});
