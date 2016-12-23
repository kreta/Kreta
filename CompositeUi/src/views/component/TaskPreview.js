/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_task-preview';

import classnames from 'classnames';
import React from 'react';

import Thumbnail from './Thumbnail';

class TaskPreview extends React.Component {
  getPriorityColor(priority) {
    if (priority === 'low') {
      return '#67b86a';
    } else if (priority === 'medium') {
      return '#f07f2c';
    }

    return '#f02c4c';
  }

  render() {
    const
      priority = this.props.task.priority.toLowerCase(),
      progress = this.props.task.progress.toLowerCase(),
      assignee = 'Dummy assignee', // `${this.props.task.assignee.first_name} ${this.props.task.assignee.last_name}`,
      classes = classnames({
        'task-preview': true,
        'task-preview--highlight': this.props.selected,
        'task-preview--closed': progress === 'done'
      });

    return (
      <div className={classes} onClick={this.props.onClick}>
        <a className="task-preview__title">
          {this.props.task.title}
        </a>
        <div className="task-preview__icons">
          <span>
            <svg className={`task-preview__priority task-preview__priority--${progress}`}>
              <circle className="task-preview__priority-back"
                      cx="21" cy="21" r="20"
                      style={{stroke: this.getPriorityColor(priority)}}/>
              <circle className="task-preview__priority-front"
                      cx="21" cy="21" r="20"
                      style={{stroke: this.getPriorityColor(priority)}}
                      transform="rotate(-90, 21, 21)"/>
            </svg>
            <Thumbnail image={this.props.task.assignee.photo ? this.props.task.assignee.photo.name : null}
                       text={assignee}/>
          </span>
        </div>
      </div>
    );
  }
}

export default TaskPreview;
