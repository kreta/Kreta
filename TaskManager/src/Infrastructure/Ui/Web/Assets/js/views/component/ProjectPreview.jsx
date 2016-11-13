/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


import './../../../scss/components/_project-preview';

import classNames from 'classnames';
import React from 'react';
import {Link} from 'react-router';

import Icon from './Icon';

class ProjectPreview extends React.Component {
  static propTypes = {
    onMouseEnter: React.PropTypes.func,
    onShortcutClick: React.PropTypes.func,
    onShortcutEnter: React.PropTypes.func,
    onTitleClick: React.PropTypes.func,
    project: React.PropTypes.object.isRequired,
    selected: React.PropTypes.bool,
    selectedShortcut: React.PropTypes.number,
    shortcuts: React.PropTypes.array
  };

  static defaultProps = {
    shortcuts: []
  };

  triggerOnShortcutClick(index, link) {
    this.props.onShortcutClick(index, link);
  }

  triggerOnShortcutEnter(index, link) {
    this.props.onShortcutEnter(index, link);
  }

  render() {
    const shortcutItems = this.props.shortcuts.map((shortcut, index) => {
      const classes = classNames({
        'project-preview__shortcut': true,
        'project-preview__shortcut--selected': index === this.props.selectedShortcut
      });

      return (
        <Icon className={classes}
              glyph={shortcut.icon}
              key={index}
              onClick={this.triggerOnShortcutClick.bind(
                this,
                index,
                `/project/${this.props.project.id}/${shortcut.link}`
              )}
              onMouseEnter={this.triggerOnShortcutEnter.bind(
                this,
                index,
                `/project/${this.props.project.id}/${shortcut.link}`
              )}/>
      );
    });
    const classes = classNames({
      'project-preview': true,
      'project-preview--selected': this.props.selected
    });

    return (
      <div className={classes} onMouseEnter={ this.props.onMouseEnter }>
        <Link className="project-preview__title"
              onClick={this.props.onTitleClick}
              to={`/project/${this.props.project.id}`}>
          {this.props.project.name}
        </Link>

        <div className="project-preview__shortcuts">
          {shortcutItems}
        </div>
      </div>
    );
  }
}

export default ProjectPreview;
