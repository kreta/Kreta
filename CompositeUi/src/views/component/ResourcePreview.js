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

import {routes} from './../../Routes';

class ResourcePreview extends React.Component {
  static propTypes = {
    format: React.PropTypes.string,
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

  resolveRoute() {
    const {resource, type} = this.props;

    let to;
    if ('organization' === type) {
      to = routes.organization.show(resource.slug);
    } else if ('project' === type) {
      to = routes.project.show(resource.organization.slug, resource.slug);
    }

    return to;
  }

  render() {
    const
      {format, onMouseEnter, onTitleClick, resource, shortcuts, selected} = this.props,
      classes = classNames({
        'resource-preview': true,
        'resource-preview--selected': selected,
        'resource-preview--child': format === 'child'
      });

    return (
      <div className={classes} onMouseEnter={onMouseEnter}>
        <Link className="resource-preview__title"
              onClick={onTitleClick}
              to={this.resolveRoute()}>
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
