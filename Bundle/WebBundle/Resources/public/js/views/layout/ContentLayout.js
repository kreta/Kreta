/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/layout/_content.scss';

import React from 'react';

export default React.createClass({
  render() {
    return (
      <div id="content">
        {this.props.children}
      </div>
    );
  }
});
