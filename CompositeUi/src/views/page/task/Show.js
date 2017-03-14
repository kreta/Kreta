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

import CurrentProjectActions from './../../../actions/CurrentProject';

import Button from './../../component/Button';
import CardExtended from './../../component/CardExtended';
import HtmlArea from './../../component/HtmlArea';
import LoadingSpinner from './../../component/LoadingSpinner';
import {Row, RowColumn} from './../../component/Grid';
import UserCard from './../../component/UserCard';

@connect(state => ({task: state.currentProject.selectedTask}))
class Show extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentProjectActions.selectCurrentTask(params.task));
  }

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
            <HtmlArea className="task-show__description">
              {task.description}
            </HtmlArea>
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
            <CardExtended subtitle="Progress" title={task.progress}/>
          </RowColumn>
          <RowColumn small={6}>
            <CardExtended subtitle="Priority" title={task.priority}/>
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
