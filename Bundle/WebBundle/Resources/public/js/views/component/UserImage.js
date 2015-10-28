/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/components/_user-image.scss';

import React from 'react';

export default React.createClass({
  propTypes: {
    user: React.PropTypes.object.isRequired
  },
  render() {
    if (false) {
      return (
        <img className="user-image" src={this.props.user.photo.name}/>
      );
    } else {
      return (
        <div className="user-image user-image--has-char">
          <span className="user-image__char">{this.props.user.first_name.charAt(0)}</span>
        </div>
      )
    }
  }
})
