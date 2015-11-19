/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_issue-preview';
import PriorityIcon from './../../../svg/priority';

import classnames from 'classnames';
import React from 'react';

import Icon from '../component/Icon';
import UserImage from './UserImage';

class IssuePreview extends React.Component {
  render() {
    const classes = classnames({
        'issue-preview': true,
        'issue-preview--highlight': this.props.selected
      }),
      priority = this.props.issue.get('priority');

    return (
      <div className={classes} onClick={this.props.onClick}>
        <a className="issue-preview__title">
          {this.props.issue.get('title')}
        </a>
        <div className="issue-preview__icons">
          <span data-tooltip-text={`
              ${this.props.issue.get('assignee').first_name}
              ${this.props.issue.get('assignee').last_name}`}>
            <Icon className="issue-preview__priority issue-preview__priority--background"
                  glyph={PriorityIcon}
                  style={{fill: priority.color}}/>
            <Icon className="issue-preview__priority"
                  glyph={PriorityIcon}
                  style={{fill: priority.color}}/>
            <UserImage user={this.props.issue.get('assignee')}/>
          </span>
        </div>
      </div>
    );
  }
}

export default IssuePreview;
