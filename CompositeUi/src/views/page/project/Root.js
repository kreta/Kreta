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

@connect(state => ({projects: state.projects.projects}))
class Root extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentProjectActions.fetchProject(params.organization, params.project));

    if (typeof this.props.params.task !== 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentTask(this.props.params.task));
    } else {
      this.props.dispatch(CurrentProjectActions.selectCurrentTask(null));
    }
  }

  componentDidUpdate(prevProps) {
    const
      oldProject = prevProps.params.project,
      newProject = this.props.params.project,
      oldTask = prevProps.params.task,
      newTask = this.props.params.task;

    if (newProject !== oldProject) {
      this.props.dispatch(CurrentProjectActions.fetchProject(this.params.organization, this.params.project));
    }

    if (newTask !== oldTask && typeof newTask !== 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentTask(newTask));
    } else if (typeof newTask === 'undefined') {
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
