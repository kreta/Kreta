/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import Style from '../../../scss/components/_project-preview.scss';

import React from 'react';
import {Link} from 'react-router';
import classNames from 'classnames';

export default React.createClass({
  propTypes: {
    onMouseEnter: React.PropTypes.func,
    onShortcutClick: React.PropTypes.func,
    onShortcutEnter: React.PropTypes.func,
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
        <img className={classes}
             key={index}
             onClick={this.props.onShortcutClick}
             onMouseEnter={this.props.onShortcutEnter}
             src={`/bundles/kretaweb/svg/${shortcut.icon}.svg`}/>
      );
    });
    const classes = classNames({
      'project-preview': true,
      'project-preview--selected': this.props.selected
    });
    return (
      <div className={ classes } onMouseEnter={ this.props.onMouseEnter }>
        <Link className="project-preview__title" to={`/project/${this.props.project.id}`}>
          {this.props.project.get('name')}
        </Link>

        <div className="project-preview__shortcuts">
          {shortcutItems}
        </div>
      </div>
    );
  }
});
