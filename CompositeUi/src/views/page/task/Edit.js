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

@connect(state => ({currentProject: state.currentProject}))
class Edit extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentProjectActions.selectCurrentTask(params.task));
  }

  editTask(task) {
    const {dispatch} = this.props;

    dispatch(CurrentProjectActions.updateTask(task));
  }

  render() {
    const {currentProject} = this.props;

    if (currentProject.waiting || null === currentProject.selectedTask) {
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
