/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';
import { connect } from 'react-redux';
import {routeActions} from 'react-router-redux';
import Mousetrap from 'mousetrap';

import Config from './../../../Config';
import CurrentProjectActions from '../../../actions/CurrentProject';

export default class ProjectRoot extends React.Component {
  componentDidMount() {
    this.props.dispatch(CurrentProjectActions.fetchProject(this.props.params.projectId));
    if (typeof this.props.params.issueId !== 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(this.props.params.issueId));
    } else {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(null));
    }

    this.bindShortcuts();
  }

  componentDidUpdate(prevProps) {
    const oldProjectId = prevProps.params.projectId,
      newProjectId = this.props.params.projectId,
      oldIssueId = prevProps.params.issueId,
      newIssueId = this.props.params.issueId;

    if (newProjectId !== oldProjectId) {
      this.props.dispatch(CurrentProjectActions.fetchProject(newProjectId));
      this.bindShortcuts();
    }

    if (newIssueId !== oldIssueId && typeof newIssueId !== 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(newIssueId));
    } else if (typeof newIssueId === 'undefined') {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(null));
    }
  }

  componentWillUnmount() {
    Mousetrap.unbind(Config.shortcuts.issueNew);
    Mousetrap.unbind(Config.shortcuts.projectSettings);
  }

  bindShortcuts() {
    Mousetrap.bind(Config.shortcuts.issueNew, (ev) => {
      ev.preventDefault();
      this.props.dispatch(
        routeActions.push(`/project/${this.props.params.projectId}/issue/new`)
      );
    });

    Mousetrap.bind(Config.shortcuts.projectSettings, (ev) => {
      ev.preventDefault();
      this.props.dispatch(
        routeActions.push(`/project/${this.props.params.projectId}/settings`)
      );
    });
  }

  render() {
    return (
      this.props.children
    );
  }
}

const mapStateToProps = (state) => {
  return {};
};

export default connect(mapStateToProps)(ProjectRoot);
