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
    open: React.PropTypes.bool
  },
  render() {
    return (
      <div>
        {this.props.children}
      </div>
    );
  }
})
