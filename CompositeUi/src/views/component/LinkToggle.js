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

const LinkToggle = props =>
  <div className="link-toggle">
    {props.disableLink.props.to === props.currentPath
      ? props.enableLink
      : props.disableLink}
  </div>;

LinkToggle.PropTypes = {
  currentPath: React.PropTypes.string.isRequired,
  disableLink: React.PropTypes.object.isRequired,
  enableLink: React.PropTypes.object.isRequired,
};

export default LinkToggle;
