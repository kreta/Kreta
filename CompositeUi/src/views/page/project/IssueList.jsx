/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import SettingsIcon from './../../../svg/settings';

import React from 'react';
import Mousetrap from 'mousetrap';
import { connect } from 'react-redux';
import {routeActions} from 'react-router-redux';
import {Link} from 'react-router';

import Config from './../../../Config';

import Button from './../../component/Button';
import Icon from './../../component/Icon';
import Filter from './../../component/Filter';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import IssuePreview from './../../component/IssuePreview';
import IssueShow from './../issue/Show';
import LoadingSpinner from './../../component/LoadingSpinner.jsx';
import PageHeader from './../../component/PageHeader';
import Thumbnail from './../../component/Thumbnail';
import InlineLink from './../../component/InlineLink';
import CurrentProjectActions from '../../../actions/CurrentProject';

@connect(state => ({currentProject: state.currentProject}))
export default class extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;
    Mousetrap.bind(Config.shortcuts.issueNew, () => {
      dispatch(
        routeActions.push(`/project/${params.projectId}/issue/new`)
      );
    });
    Mousetrap.bind(Config.shortcuts.projectSettings, () => {
      dispatch(
        routeActions.push(`/project/${params.projectId}/settings`)
      );
    });
  }

  filterIssues(filters) {
    const data = {project: this.state.project.id};

    filters.forEach((filter) => {
      filter.forEach((item) => {
        if (item.selected) {
          data[item.filter] = item.value;
        }
      });
    });

    this.props.dispatch(CurrentProjectActions.filterIssues(data));
  }

//  loadFilters(project) {
//    var assigneeFilters = [{
//        filter: 'assignee',
//        selected: true,
//        title: 'All',
//        value: ''
//      }, {
//        filter: 'assignee',
//        selected: false,
//        title: 'Assigned to me',
//        value: this.props.profile.profile.id
//      }],
//      priorityFilters = [{
//        filter: 'priority',
//        selected: true,
//        title: 'All priorities',
//        value: ''
//      }
//      ],
//      priorities = [], //project.get('issue_priorities'),
//      statusFilters = [{
//        filter: 'status',
//        selected: true,
//        title: 'All statuses',
//        value: ''
//      }],
//      statuses = [];// project.get('statuses');
//
//    if (priorities) {
//      priorities.forEach((priority) => {
//        priorityFilters.push({
//          filter: 'priority',
//          selected: false,
//          title: priority.name,
//          value: priority.id
//        });
//      });
//    }
//
//    if (statuses) {
//      statuses.forEach((status) => {
//        statusFilters.push({
//          filter: 'status',
//          selected: false,
//          title: status.name,
//          value: status.id
//        });
//      });
//    }
//    this.setState({filters: [assigneeFilters, priorityFilters, statusFilters]});
//  }

  selectCurrentIssue(issue) {
    const {dispatch, params} = this.props;
    dispatch(
      routeActions.push(`/project/${params.projectId}/issue/${issue.id}`)
    );
  }

  hideIssue() {
    const {dispatch, params} = this.props;
    dispatch(
      routeActions.push(`/project/${params.projectId}`)
    );
  }

  getIssuesEl() {
    const {currentProject, params} = this.props;
    return currentProject.issues.map((issue, index) => {
      return <IssuePreview issue={issue}
                           key={index}
                           onClick={this.selectCurrentIssue.bind(this, issue)}
                           selected={params.issueId === issue.id}/>;
    });
  }

  getSelectedIssueEl() {
    const {currentProject} = this.props;
    if (null === currentProject.selectedIssue) {
      return '';
    }

    return <IssueShow issue={currentProject.selectedIssue}
                      project={currentProject.project}/>;
  }

  render() {
    const {currentProject, params} = this.props;
    if (currentProject.fetchingProjects || currentProject.fetchingIssues) {
      return <LoadingSpinner/>;
    }
    return (
      <div>
        <ContentMiddleLayout>
          <PageHeader thumbnail={<Thumbnail image={currentProject.project.image.name}
                                            text={currentProject.project.name}/>}
                      title={currentProject.project.name}>
            <InlineLink to={`/project/${currentProject.project.id}/settings`}>
              <Icon glyph={SettingsIcon} color="green" size="small"/>Settings
            </InlineLink>
            <Link to={`/project/${params.projectId}/issue/new`}>
              <Button color="green">New issue</Button>
            </Link>
          </PageHeader>
          <Filter filters={currentProject.filters}
                  onFilterSelected={this.filterIssues.bind(this)}/>
          {this.getIssuesEl()}
        </ContentMiddleLayout>
        <ContentRightLayout isOpen={currentProject.selectedIssue !== null}
                            onRequestClose={this.hideIssue.bind(this)}>
          {this.getSelectedIssueEl()}
        </ContentRightLayout>
      </div>
    );
  }
}
