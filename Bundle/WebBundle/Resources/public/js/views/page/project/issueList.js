/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */
import React from 'react';

import {IssueCollection} from '../../../collections/issue';
import IssuePreview from '../../component/issuePreview.js';
import Filter from '../../component/filter.js';

export default React.createClass({
  propTypes: {
    project: React.PropTypes.object.isRequired
  },
  getInitialState() {
    return {
      project: null,
      filters: [],
      issues: [],
      fetchingIssues: true
    };
  },
  componentDidMount() {
    this.state.project = App.collection.project.get(this.props.params.projectId);
    this.state.project.on('sync', $.proxy(this.loadFilters, this));
    this.state.project.on('change', $.proxy(this.loadFilters, this));

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
  render() {
    if(!this.state.project) {
      return <p>Loading...</p>
    }
    let issuesEl = this.state.issues.map((issue) => {
      return <IssuePreview issue={issue}/>
    });
    return (
      <div>
        <div className="page-header">
          <div className="project-image" style={{background: '#ebebeb'}}></div>
          <h2 className="page-header-title">{this.state.project.get('name')}</h2>
          <div>
            <a className="page-header-link" href="#">
              <i className="fa fa-dashboard"></i>
            Dashboard
            </a>
            <a id="project-settings-show"
            className="page-header-link"
            href={`/projects/${this.state.project.id}/settings`}
            data-bypass>
              <i className="fa fa-settings"></i>
            Settings
            </a>
          </div>
        </div>
        <Filter filters={this.state.filters} onFilterSelected={this.filterIssues}/>
        <div className="issues">
            {this.state.fetchingIssues ? 'Loading...' : issuesEl}
        </div>
      </div>
    );
  }
})
