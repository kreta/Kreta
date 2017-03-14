/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/task/_show';

import {connect} from 'react-redux';
import React from 'react';
import {Link} from 'react-router';

import {routes} from './../../../Routes';

import Button from './../../component/Button';
import LoadingSpinner from './../../component/LoadingSpinner';
import {Row, RowColumn} from './../../component/Grid';
import UserCard from './../../component/UserCard';

@connect(state => ({task: state.currentProject.selectedTask}))
class Show extends React.Component {
  render() {
    const {task, params} = this.props;

    if (!task) {
      return (
        <div className="task-show">
          <LoadingSpinner/>
        </div>
      );
    }

    return (
      <div className="task-show">
        <Row>
          <RowColumn>
            <h1 className="task-show__title">
              {task.title}
            </h1>
            <p className="task-show__description">
              {task.description}
            </p>
          </RowColumn>
        </Row>
        <Row className="task-show__fields">
          <RowColumn small={6}>
            <span>Assignee</span>
            <UserCard user={task.assignee}/>
          </RowColumn>
          <RowColumn small={6}>
            <span>Creator</span>
            <UserCard user={task.creator}/>
          </RowColumn>
        </Row>
        <Row className="task-show__fields">
          <RowColumn small={6}>
            <p>Progress: <strong>{task.progress}</strong></p>
          </RowColumn>
          <RowColumn small={6}>
            <p>Priority: <strong>{task.priority}</strong></p>
          </RowColumn>
        </Row>
        <Row className="task-show__fields">
          <RowColumn>
            <Link to={routes.task.edit(params.organization, params.project, params.task)}>
              <Button color="green">Edit</Button>
            </Link>
          </RowColumn>
        </Row>
      </div>
    );
  }
}

export default Show;
