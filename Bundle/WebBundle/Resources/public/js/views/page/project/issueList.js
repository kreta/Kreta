/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';
import {Link} from 'react-router';

import {IssueCollection} from '../../../collections/Issue';
import IssuePreview from '../../component/IssuePreview.js';
import Filter from '../../component/Filter.js';
import IssueShow from '../../page/issue/Show.js';
import NavigableCollection from '../../../mixins/NavigableCollection.js';
import MiddleContentLayout from '../../layout/MiddleContentLayout.js';
import RightContentLayout from '../../layout/RightContentLayout.js';
import PageHeader from '../../component/PageHeader.js';

export default React.createClass({
  getInitialState() {
    return {
      project: null,
      filters: [],
      issues: [],
      fetchingIssues: true
    };
  },
  mixins: [NavigableCollection],
  componentDidMount() {
    this.state.project = App.collection.project.get(this.props.params.projectId);
    this.state.project.on('sync', this.loadFilters);
    this.state.project.on('change', this.loadFilters);

    this.collection = new IssueCollection();
    this.collection.on('sync', $.proxy(this.issuesUpdated, this));
    this.collection.fetch({data: {project: this.state.project.id}});

    this.loadFilters();
  },
  issuesUpdated(data) {
    this.setState({
      issues: data,
      fetchingIssues: false
    });
  },
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
  },
  loadFilters() {
    var assigneeFilters = [{
        title: 'All',
        filter: 'assignee',
        value: '',
        selected: true
      }, {
        title: 'Assigned to me',
        filter: 'assignee',
        value: App.currentUser.get('id'),
        selected: false
      }],
      priorityFilters = [
        {
          title: 'All priorities',
          filter: 'priority',
          value: '',
          selected: true
        }
      ],
      priorities = this.state.project.get('issue_priorities'),
      statusFilters = [{
        title: 'All statuses',
        filter: 'status',
        value: '',
        selected: true
      }],
      statuses = this.state.project.get('statuses');

    if (priorities) {
      priorities.forEach((priority) => {
        priorityFilters.push({
          title: priority.name,
          filter: 'priority',
          value: priority.id,
          selected: false
        });
      });
    }

    if (statuses) {
      statuses.forEach((status) => {
        statusFilters.push({
          title: status.name,
          filter: 'status',
          value: status.id,
          selected: false
        });
      });
    }

    this.setState({filters: [assigneeFilters, priorityFilters, statusFilters]});
  },
  changeSelected(ev) {
    this.setState({
      selectedItem: $(ev.currentTarget).index()
    });
  },
  render() {
    if (!this.state.project) {
      return <p>Loading...</p>;
    }
    const issuesEl = this.state.issues.map((issue, index) => {
      return <IssuePreview issue={issue}
                           key={index}
                           selected={this.state.selectedItem === index}
                           onClick={this.changeSelected}/>;
    });
    let issue = '';
    if(this.state.issues.length > 0 || this.state.fetchingIssues) {
      issue = <IssueShow issue={this.state.issues.at(this.state.selectedItem)}/>;
    }
    const links = [{
      title: 'Dashboard',
      icon: 'dashboard',
      href: '#'
    }, {
      title: 'Settings',
      icon: 'settings',
      href: `/project/${this.state.project.id}/settings`
    }];
    return (
      <div>
        <MiddleContentLayout>
          <PageHeader image="" title="" links={links}/>
          <Filter filters={this.state.filters} onFilterSelected={this.filterIssues}/>
          <div className="issues">
            {this.state.fetchingIssues ? 'Loading...' : issuesEl}
          </div>
        </MiddleContentLayout>
        <RightContentLayout>
          {issue}
        </RightContentLayout>
      </div>
    );
  }
});
