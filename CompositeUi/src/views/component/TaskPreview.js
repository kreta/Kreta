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
  static propTypes = {
    onClick: React.PropTypes.func.isRequired,
    task: React.PropTypes.object.isRequired
  };

  static TASK_PRIORITIES = {
    LOW: '#67b86a',
    MEDIUM: '#f07f2c',
    HIGH: '#f02c4c'
  };

  getPriorityColor(priority) {
    priority = priority.toUpperCase();

    return TaskPreview.TASK_PRIORITIES[priority];
  }

  render() {
    const
      {onClick, task} = this.props,
      priority = task.priority.toLowerCase(),
      progress = task.progress.toLowerCase(),
      assignee = task.assignee,
      classes = classnames({
        'task-preview': true,
        'task-preview--highlight': this.props.selected,
        'task-preview--closed': progress === 'done'
      });

    return (
      <div className={classes} onClick={onClick}>
        <a className="task-preview__title">
          {task.title}
        </a>
        <div className="task-preview__icons">
          <span>
            <svg className={`task-preview__priority task-preview__priority--${progress}`}>
              <circle
                className="task-preview__priority-back"
                cx="21" cy="21" r="20"
                style={{stroke: this.getPriorityColor(priority)}}
              />
              <circle
                className="task-preview__priority-front"
                cx="21" cy="21" r="20"
                style={{stroke: this.getPriorityColor(priority)}}
                transform="rotate(-90, 21, 21)"
              />
            </svg>
            <Thumbnail
              image={assignee.photo ? assignee.photo.name : null}
              text={assignee.email}
            />
          </span>
        </div>
      </div>
    );
  }
}

export default TaskPreview;
