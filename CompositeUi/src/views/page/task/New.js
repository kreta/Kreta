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
import TaskNew from './../../form/TaskNew';

@connect(state => ({currentProject: state.currentProject}))
class New extends React.Component {
  createTask(task) {
    const {dispatch} = this.props;

    dispatch(CurrentProjectActions.createTask(task));
  }

  render() {
    const {currentProject} = this.props;

    if (currentProject.waiting) {
      return <LoadingSpinner />;
    }

    return (
      <ContentMiddleLayout centered>
        <TaskNew onSubmit={this.createTask.bind(this)} />
      </ContentMiddleLayout>
    );
  }
}

export default New;
