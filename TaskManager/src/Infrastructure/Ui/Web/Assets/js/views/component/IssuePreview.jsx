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

import classnames from 'classnames';
import React from 'react';

import Thumbnail from './Thumbnail';

class IssuePreview extends React.Component {
  render() {
    const priority = this.props.issue.priority,
      statusType = this.props.issue.status.type,
      classes = classnames({
        'issue-preview': true,
        'issue-preview--highlight': this.props.selected,
        'issue-preview--closed': statusType === 'final'
      });

    return (
      <div className={classes} onClick={this.props.onClick}>
        <a className="issue-preview__title">
          {this.props.issue.title}
        </a>
        <div className="issue-preview__icons">
          <span data-tooltip-text={`
              ${this.props.issue.assignee.first_name}
              ${this.props.issue.assignee.last_name}`}>
            <svg className={`issue-preview__priority issue-preview__priority--${statusType}`}>
              <circle className="issue-preview__priority-back"
                      cx="21" cy="21" r="20"
                      style={{stroke: priority.color}}/>
              <circle className="issue-preview__priority-front"
                      cx="21" cy="21" r="20"
                      style={{stroke: priority.color}}
                      transform="rotate(-90, 21, 21)"/>
            </svg>
            <Thumbnail image={this.props.issue.assignee.photo ? this.props.issue.assignee.photo.name : null}
                       text={`${this.props.issue.assignee.first_name} ${this.props.issue.assignee.last_name}`}/>
          </span>
        </div>
      </div>
    );
  }
}

export default IssuePreview;
