/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {connect} from 'react-redux';
import React from 'react';

import ProjectActions from './../../../actions/CurrentProject';
import TaskEdit from './../../form/TaskEdit';

@connect(state => ({currentProject: state.currentProject}))
class Show extends React.Component {
  updateTask(task) {
    this.props.dispatch(ProjectActions.updateTask(task));
  }

  render() {
    return (
      <TaskEdit onSubmit={this.updateTask.bind(this)}/>
    );
  }
}

export default Show;
