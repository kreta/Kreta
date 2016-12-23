/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import CurrentProjectActions from './../../../actions/CurrentProject';

import React from 'react';
import {connect} from 'react-redux';

@connect()
class Root extends React.Component {
  componentDidMount() {
    this.props.dispatch(CurrentProjectActions.fetchProject(this.props.params.projectId));
    if (typeof this.props.params.taskId !== 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentTask(this.props.params.taskId));
    } else {
      this.props.dispatch(CurrentProjectActions.selectCurrentTask(null));
    }
  }

  componentDidUpdate(prevProps) {
    const oldProjectId = prevProps.params.projectId,
      newProjectId = this.props.params.projectId,
      oldTaskId = prevProps.params.taskId,
      newTaskId = this.props.params.taskId;

    if (newProjectId !== oldProjectId) {
      this.props.dispatch(CurrentProjectActions.fetchProject(newProjectId));
    }

    if (newTaskId !== oldTaskId && typeof newTaskId !== 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentTask(newTaskId));
    } else if (typeof newTaskId === 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentTask(null));
    }
  }

  render() {
    return (
      this.props.children
    );
  }
}

export default Root;
