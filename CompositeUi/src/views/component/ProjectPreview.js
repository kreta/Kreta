/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_project-preview';

import classNames from 'classnames';
import React from 'react';
import {Link} from 'react-router';

class ProjectPreview extends React.Component {
  static propTypes = {
    onMouseEnter: React.PropTypes.func,
    onTitleClick: React.PropTypes.func,
    project: React.PropTypes.object.isRequired,
    selected: React.PropTypes.bool,
    shortcuts: React.PropTypes.element
  };

  static defaultProps = {
    shortcuts: ''
  };

  render() {
    const {onMouseEnter, onTitleClick, project, shortcuts, selected} = this.props,
      classes = classNames({
        'project-preview': true,
        'project-preview--selected': selected
      });

    return (
      <div className={classes} onMouseEnter={onMouseEnter}>
        <Link className="project-preview__title"
              onClick={onTitleClick}
              to={`/project/${project.id}`}>
          {project.name}
        </Link>

        <div className="project-preview__shortcuts">
          {shortcuts}
        </div>
      </div>
    );
  }
}

export default ProjectPreview;
