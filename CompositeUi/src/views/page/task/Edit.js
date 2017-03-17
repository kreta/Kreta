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

import CurrentProjectActions from './../../../actions/CurrentProject';

import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import LoadingSpinner from './../../component/LoadingSpinner';
import TaskEdit from './../../form/TaskEdit';

@connect(state => ({task: state.currentProject.selectedTask}))
class Edit extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentProjectActions.selectCurrentTask(params.task));
  }

  editTask(updatedTask) {
    const
      {dispatch, task} = this.props,
      id = task.id;

    dispatch(CurrentProjectActions.updateTask({...updatedTask, id}));
  }

  render() {
    const {task} = this.props;

    if (!task) {
      return <LoadingSpinner/>;
    }

    return (
      <ContentMiddleLayout centered>
        <TaskEdit onSubmit={this.editTask.bind(this)}/>
      </ContentMiddleLayout>
    );
  }
}

export default Edit;
