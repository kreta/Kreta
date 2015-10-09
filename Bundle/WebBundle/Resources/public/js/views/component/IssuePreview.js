/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';
import classnames from 'classnames';

import '../../../scss/components/_issue-preview.scss';

export default React.createClass({
  render() {
    const classes = classnames({
      'issue-preview': true,
      'issue-preview--highlight': this.props.selected
    });
    return (
      <div className={classes} onClick={this.props.onClick}>
        <div className="issue-preview__details">
          <a className="issue-preview__title">
            {this.props.issue.get('title')}
          </a>
        </div>
        <div className="issue-preview__icons">
          <span className="issue-preview__icon"
                data-tooltip-text={ this.props.issue.get('status').name }>
            <i className="fa fa-check"
               style={{color: this.props.issue.get('status').color }}></i>
          </span>
          <span data-tooltip-text={`
              ${this.props.issue.get('assignee').first_name}
              ${this.props.issue.get('assignee').last_name}`}>
            <img className="user-image"
                 src={this.props.issue.get('assignee').photo.name }/>
          </span>
        </div>
      </div>
    );
  }
});
