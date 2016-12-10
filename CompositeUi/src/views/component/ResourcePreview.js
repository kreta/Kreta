/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_resource-preview';

import classNames from 'classnames';
import {Link} from 'react-router';
import React from 'react';

class ResourcePreview extends React.Component {
  static propTypes = {
    onMouseEnter: React.PropTypes.func,
    onTitleClick: React.PropTypes.func,
    resource: React.PropTypes.object.isRequired,
    selected: React.PropTypes.bool,
    shortcuts: React.PropTypes.oneOfType([
      React.PropTypes.string,
      React.PropTypes.element
    ]),
    type: React.PropTypes.string.isRequired
  };

  static defaultProps = {
    shortcuts: ''
  };

  render() {
    const
      {onMouseEnter, onTitleClick, resource, type, shortcuts, selected} = this.props,
      classes = classNames({
        'resource-preview': true,
        'resource-preview--selected': selected
      });

    return (
      <div className={classes} onMouseEnter={onMouseEnter}>
        <Link className="resource-preview__title"
              onClick={onTitleClick}
              to={`/${type}/${resource.id}`}>
          {resource.name}
        </Link>

        <div className="resource-preview__shortcuts">
          {shortcuts}
        </div>
      </div>
    );
  }
}

export default ResourcePreview;
