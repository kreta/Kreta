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
import FormActions from './../../component/FormActions';
import LoadingSpinner from './../../component/LoadingSpinner';
import {Row, RowColumn} from './../../component/Grid';
import SelectorOption from './../../component/SelectorOption';
import Thumbnail from './../../component/Thumbnail';

@connect(state => ({task: state.currentProject.selectedTask}))
class Show extends React.Component {
  assignee(task) {
    return !task.assignee.first_name ? 'Dummy assignee' : `${task.assignee.first_name} ${task.assignee.last_name}`;
  }

  creator(task) {
    return !task.creator.first_name ? 'Dummy creator' : `${task.creator.first_name} ${task.creator.last_name}`;
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
      <div>
        <Row>
          <RowColumn>
            <h1 className="task-show__title">{task.title}</h1>
             <p className="task-show__description">{task.description}</p>
          </RowColumn>
        </Row>
        <Row className="task-show__fields">
          <RowColumn small={6}>
            <SelectorOption
              alignLeft
              label="Assignee"
              text={this.assignee(task)}
              thumbnail={<Thumbnail image={null} text={this.assignee(task)}/>}
              value="1"
            />
          </RowColumn>
          <RowColumn small={6}>
            <SelectorOption
              alignLeft
              label="Creator"
              text={this.creator(task)}
              thumbnail={<Thumbnail image={null} text={this.creator(task)}/>}
              value="1"
            />
          </RowColumn>
        </Row>
        <Row className="task-show__fields">
          <RowColumn small={6}>
            <SelectorOption alignLeft label="Progress" left text={task.progress} value="1"/>
          </RowColumn>
          <RowColumn small={6}>
            <SelectorOption alignLeft label="Priority" left text={task.priority} value="1"/>
          </RowColumn>
        </Row>
        <Row>
          <RowColumn>
            <FormActions>
              <Link to={routes.task.edit(params.organization, params.project, params.task)}>
                <Button color="green">Edit</Button>
              </Link>
            </FormActions>
          </RowColumn>
        </Row>
      </div>
    );
  }
}

export default Show;
