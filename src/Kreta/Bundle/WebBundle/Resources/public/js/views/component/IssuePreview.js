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
import classnames from 'classnames';

import '../../../scss/components/_issue-preview.scss';

import UserImage from '../component/UserImage.js';

export default React.createClass({
  render() {
    const classes = classnames({
      'issue-preview': true,
      'issue-preview--highlight': this.props.selected
    });
    return (
      <div className={classes} onClick={this.props.onClick}>
        <a className="issue-preview__title">
          {this.props.issue.get('title')}
        </a>
        <div className="issue-preview__icons">
          <span className="issue-preview__icon"
                data-tooltip-text={ this.props.issue.get('status').name }>
            <i className="fa fa-check"
               style={{color: this.props.issue.get('status').color }}></i>
          </span>
          <span data-tooltip-text={`
              ${this.props.issue.get('assignee').first_name}
              ${this.props.issue.get('assignee').last_name}`}>
            <UserImage user={this.props.issue.get('assignee')}/>
          </span>
        </div>
      </div>
    );
  }
});
