/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import SettingsIcon from './../../../../svg/settings';

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
import NavigableList from './../../component/NavigableList';
import InlineLink from './../../component/InlineLink';
import CurrentProjectActions from '../../../actions/CurrentProject';

@connect(state => ({currentProject: state.currentProject}))
export default class extends React.Component {
  componentDidMount() {
    const projectId = this.props.params.projectId;
    Mousetrap.bind(Config.shortcuts.issueNew, () => {
      this.props.dispatch(
        routeActions.push(`/project/${projectId}/issue/new`)
      );
    });
    Mousetrap.bind(Config.shortcuts.projectSettings, () => {
      this.props.dispatch(
        routeActions.push(`/project/${projectId}/settings`)
      );
    });

    this.keyUpListenerRef = this.keyboardNavigate.bind(this);
    window.addEventListener('keyup', this.keyUpListenerRef);
  }

  componentWillUnmount() {
    window.removeEventListener('keyup', this.keyUpListenerRef);
  }

  keyboardNavigate(ev) {
    //this.refs.navigableList.handleNavigation(ev);
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
    this.props.dispatch(CurrentProjectActions.selectCurrentIssue(issue));
  }

  hideIssue() {
    this.props.dispatch(CurrentProjectActions.selectCurrentIssue(null));
  }

  getIssuesEl() {
    return this.props.currentProject.issues.map((issue, index) => {
      return <IssuePreview issue={issue}
                           key={index}
                           onClick={this.selectCurrentIssue.bind(this, issue)}
                           selected={this.props.currentProject.selectedIssue &&
                           this.props.currentProject.selectedIssue.id === issue.id}/>;
    });
  }

  getSelectedIssueEl() {
    if (!this.props.currentProject.selectedIssue) {
      return '';
    }

    return <IssueShow issue={this.props.currentProject.selectedIssue}
                      project={this.props.currentProject.project}/>;
  }

  render() {
    if (this.props.currentProject.fetchingProjects || this.props.currentProject.fetchingIssues) {
      return <LoadingSpinner/>;
    }
    const projectId = this.props.params.projectId;
    return (
      <div>
        <ContentMiddleLayout>
          <PageHeader thumbnail={<Thumbnail image={this.props.currentProject.project.image.name}
                                            text={this.props.currentProject.project.name}/>}
                      title={this.props.currentProject.project.name}>
            <InlineLink to={`/project/${this.props.currentProject.project.id}/settings`}>
              <Icon glyph={SettingsIcon} color="green" size="small"/>Settings
            </InlineLink>
            <Link to={`/project/${projectId}/issue/new`}>
              <Button color="green">New issue</Button>
            </Link>
          </PageHeader>
          <Filter filters={this.props.currentProject.filters}
                  onFilterSelected={this.filterIssues.bind(this)}/>

          {this.getIssuesEl()}
        </ContentMiddleLayout>
        <ContentRightLayout isOpen={this.props.currentProject.selectedIssue}
                            onRequestClose={this.hideIssue.bind(this)}>
          {this.getSelectedIssueEl()}
        </ContentRightLayout>
      </div>
    );
  }
}
