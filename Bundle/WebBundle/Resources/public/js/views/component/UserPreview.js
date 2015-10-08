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
  render() {
    const participant = this.props.user;

    return (
      <div className="image-preview project-settings-participant">
        <img className="image-preview-image user-image"
             src={participant.user.photo.name}/>

        <div className="image-preview-container">
              <span className="image-preview-header">
                  {participant.user.first_name} {participant.user.last_name}
              </span>
          <span className="image-preview-subheader">{this.props.user.role}</span>
        </div>
      </div>
    );
  }
});
