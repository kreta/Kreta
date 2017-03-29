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

@connect(state => ({projects: state.projects.projects}))
class Root extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentProjectActions.fetchProject(params.organization, params.project));

    if (typeof this.props.params.task !== 'undefined') {
      dispatch(CurrentProjectActions.selectCurrentTask(params.task));
    } else {
      dispatch(CurrentProjectActions.selectCurrentTask(null));
    }
  }

  componentDidUpdate(prevProps) {
    const {params, dispatch} = this.props;

    if (params.project !== prevProps.params.project) {
      dispatch(CurrentProjectActions.fetchProject(params.organization, params.project));
    }

    if (params.task !== prevProps.params.task && typeof params.task !== 'undefined') {
      dispatch(CurrentProjectActions.selectCurrentTask(params.task));
    } else if (typeof params.task === 'undefined') {
      dispatch(CurrentProjectActions.selectCurrentTask(null));
    }
  }

  render() {
    return (
      this.props.children
    );
  }
}

export default Root;
