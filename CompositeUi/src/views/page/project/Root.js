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
    if (typeof this.props.params.issueId !== 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(this.props.params.issueId));
    } else {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(null));
    }
  }

  componentDidUpdate(prevProps) {
    const oldProjectId = prevProps.params.projectId,
      newProjectId = this.props.params.projectId,
      oldIssueId = prevProps.params.issueId,
      newIssueId = this.props.params.issueId;

    if (newProjectId !== oldProjectId) {
      this.props.dispatch(CurrentProjectActions.fetchProject(newProjectId));
    }

    if (newIssueId !== oldIssueId && typeof newIssueId !== 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(newIssueId));
    } else if (typeof newIssueId === 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(null));
    }
  }

  render() {
    return (
      this.props.children
    );
  }
}

export default Root;
