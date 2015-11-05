/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_project-preview.scss';

import React from 'react';
import classNames from 'classnames';

import Icon from './Icon.js';

export default React.createClass({
  propTypes: {
    onMouseEnter: React.PropTypes.func,
    onShortcutClick: React.PropTypes.func,
    onShortcutEnter: React.PropTypes.func,
    onTitleClick: React.PropTypes.func,
    project: React.PropTypes.object.isRequired,
    selected: React.PropTypes.bool,
    selectedShortcut: React.PropTypes.number,
    shortcuts: React.PropTypes.array.isRequired
  },
  render() {
    var shortcutItems = this.props.shortcuts.map((shortcut, index) => {
      const classes = classNames({
        'project-preview__shortcut': true,
        'project-preview__shortcut--selected': index === this.props.selectedShortcut
      });
      return (
        <Icon className={classes}
              glyph={shortcut.icon}
              key={index}
              onClick={this.props.onShortcutClick}
              onMouseEnter={this.props.onShortcutEnter}/>
      );
    });
    const classes = classNames({
      'project-preview': true,
      'project-preview--selected': this.props.selected
    });
    return (
      <div className={ classes } onMouseEnter={ this.props.onMouseEnter }>
        <div className="project-preview__title" onClick={this.props.onTitleClick}>
          {this.props.project.get('name')}
        </div>

        <div className="project-preview__shortcuts">
          {shortcutItems}
        </div>
      </div>
    );
  }
});
