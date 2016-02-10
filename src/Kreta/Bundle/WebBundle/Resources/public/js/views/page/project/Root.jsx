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
    this.fetchContent()
  }

  componentDidUpdate(prevProps) {
    if(prevProps.params.project !== this.props.params.project ||
      prevProps.params.organization !== this.props.params.organization) {
      this.fetchContent();
      return;
    }

    if(prevProps.params.issueId !== this.props.params.issueId) {
      this.props.dispatch(CurrentProjectActions.selectCurrentIssue(
        typeof this.props.params.issueId !== 'undefined' ? this.props.params.issueId : null
      ));
    }
  }

  componentWillUnmount() {
    Mousetrap.unbind(Config.shortcuts.issueNew);
    Mousetrap.unbind(Config.shortcuts.projectSettings);
  }

  fetchContent() {
    this.props.dispatch(CurrentProjectActions.fetchProject(
      this.props.params.organization,
      this.props.params.project
    ));
    this.props.dispatch(CurrentProjectActions.selectCurrentIssue(
      typeof this.props.params.issueId !== 'undefined' ? this.props.params.issueId : null
    ));

    this.bindShortcuts();
  }

  bindShortcuts() {
    Mousetrap.bind(Config.shortcuts.issueNew, (ev) => {
      ev.preventDefault();
      this.props.dispatch(
        routeActions.push(`/${this.props.project.organization.slug}/${this.props.project.slug}/issue/new`)
      );
    });

    Mousetrap.bind(Config.shortcuts.projectSettings, (ev) => {
      ev.preventDefault();
      this.props.dispatch(
        routeActions.push(`/${this.props.project.organization.slug}/${this.props.project.slug}/settings`)
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
  return {
    project: state.currentProject.project
  };
};

export default connect(mapStateToProps)(ProjectRoot);
