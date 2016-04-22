/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_organization-preview';

import React from 'react';
import {Link} from 'react-router';

class ProjectPreview extends React.Component {
  static propTypes = {
    organization: React.PropTypes.object.isRequired
  };

  render() {
    return (
      <Link className="organization-preview"
            to={`/${this.props.organization.slug}/`}>
        {this.props.organization.name}
      </Link>
    );
  }
}

export default ProjectPreview;
