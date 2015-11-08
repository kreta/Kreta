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

import $ from 'jquery';
import React from 'react';

import Filter from './../../component/Filter';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import IssuePreview from './../../component/IssuePreview';
import Issues from './../../../collections/Issues';
import IssueShow from './../issue/Show';
import PageHeader from './../../component/PageHeader';
import NavigableList from './../../component/NavigableList';

class IssueList extends React.Component {
  state = {
    fetchingIssues: true,
    filters: [],
    issues: [],
    project: null
  };

  componentDidMount() {
    this.loadData();
    document.addEventListener('keyup', this.keyboardNavigate.bind(this));
  }

  componentDidUpdate(prevProps) {
    const oldId = prevProps.params.projectId,
      newId = this.props.params.projectId;
    if (newId !== oldId) {
      this.loadData();
    }
  }

  componentWillUnmount() {
    document.addEventListener('keyup', this.keyboardNavigate.bind(this));
  }

  keyboardNavigate(ev) {
    this.refs.navigableList.handleNavigation(ev);
  }

  loadData() {
    const project = App.collection.project.get(this.props.params.projectId);
    project.on('sync', this.loadFilters.bind(this));
    project.on('change', this.loadFilters.bind(this));

    this.setState({
      fetchingIssues: true,
      issues: [],
      project,
      selectedRow: 0
    });

    this.collection = new Issues();
    this.collection.on('sync', $.proxy(this.issuesUpdated, this));
    this.collection.fetch({data: {project: project.id}});

    this.loadFilters(project);
  }

  issuesUpdated(data) {
    this.setState({
      fetchingIssues: false,
      issues: data,
      selectedRow: 0
    });
  }

  filterIssues(filters) {
    var data = {project: this.state.project.id};

    filters.forEach((filter) => {
      filter.forEach((item) => {
        if (item.selected) {
          data[item.filter] = item.value;
        }
      });
    });

    this.setState({fetchingIssues: true});
    this.collection.fetch({data, reset: true});
  }

  loadFilters(project) {
    var assigneeFilters = [{
        filter: 'assignee',
        selected: true,
        title: 'All',
        value: ''
      }, {
        filter: 'assignee',
        selected: false,
        title: 'Assigned to me',
        value: App.currentUser.get('id')
      }],
      priorityFilters = [{
        filter: 'priority',
        selected: true,
        title: 'All priorities',
        value: ''
      }
      ],
      priorities = project.get('issue_priorities'),
      statusFilters = [{
        filter: 'status',
        selected: true,
        title: 'All statuses',
        value: ''
      }],
      statuses = project.get('statuses');

    if (priorities) {
      priorities.forEach((priority) => {
        priorityFilters.push({
          filter: 'priority',
          selected: false,
          title: priority.name,
          value: priority.id
        });
      });
    }

    if (statuses) {
      statuses.forEach((status) => {
        statusFilters.push({
          filter: 'status',
          selected: false,
          title: status.name,
          value: status.id
        });
      });
    }
    this.setState({filters: [assigneeFilters, priorityFilters, statusFilters]});
  }

  changeSelected(index) {
    this.setState({selectedRow: index});
  }

  render() {
    if (!this.state.project) {
      return <p>Loading...</p>;
    }
    const issuesEl = this.state.issues.map((issue, index) => {
        return <IssuePreview issue={issue}
                             key={index}
                             onClick={this.changeSelected.bind(this, index)}
                             selected={this.state.selectedRow === index}/>;
      }),
      links = [{
        href: `/project/${this.state.project.id}/settings`,
        icon: SettingsIcon,
        title: 'Settings',
        color: 'green'
      }],
      buttons = [{
        href: `/issue/new/${this.state.project.id}`,
        title: 'New issue'
      }];
    let issue = '';
    if (this.state.issues.length > 0 && !this.state.fetchingIssues) {
      issue = <IssueShow issue={this.state.issues.at(this.state.selectedRow)}
                         project={this.state.project}/>;
    }

    return (
      <div>
        <ContentMiddleLayout>
          <PageHeader buttons={buttons}
                      image=""
                      links={links}
                      title={this.state.project.get('name')}/>
          <Filter filters={this.state.filters} onFilterSelected={this.filterIssues.bind(this)}/>

          <NavigableList className="issues"
                         onYChanged={this.changeSelected.bind(this)}
                         ref="navigableList"
                         yLength={issuesEl.length}>
            {this.state.fetchingIssues ? 'Loading...' : issuesEl}
          </NavigableList>
        </ContentMiddleLayout>
        <ContentRightLayout open={issue !== ''}>
          {issue}
        </ContentRightLayout>
      </div>
    );
  }
}

export default IssueList;
