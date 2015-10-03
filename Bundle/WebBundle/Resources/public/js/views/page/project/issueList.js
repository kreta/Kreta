/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {FilterView} from '../../component/filter';
import {IssueCollection} from '../../../collections/issue';
import IssuePreview from '../../component/issuePreview.js';
import Filter from '../../component/filter.js';

export default React.createClass({
  propTypes: {
    project: React.PropTypes.object.isRequired
  },
  getInitialState() {
    return {
      filters: [],
      issues: []
    }
  },
  componentDidMount() {
    this.props.project.on('sync', this.render);
    this.props.project.on('change', this.render);
    this.collection = new IssueCollection();
    this.collection.fetch({data: {project: this.props.project.id}, success:
      (data) => {
        this.setState({issues: data});
    }});
    this.loadFilters();
  },
  filterIssues(filters) {
    var data = {project: this.props.project.id};

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
      priorities = this.props.project.get('issue_priorities'),
      statusFilters = [{
        title: 'All statuses',
        filter: 'status',
        value: '',
        selected: true
      }],
      statuses = this.props.project.get('statuses');

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
    let issuesEl = this.state.issues.map((issue) => {
      return <IssuePreview issue={issue}/>
    });
    return (
      <div>
        <div className="page-header">
          <div className="project-image" style={{background: '#ebebeb'}}></div>
          <h2 className="page-header-title">{this.props.project.get('name')}</h2>
            <div>
              <a className="page-header-link" href="#">
                <i className="fa fa-dashboard"></i>Dashboard
              </a>
              <a id="project-settings-show"
                 className="page-header-link"
                 href={`/projects/${this.props.project.id}/settings`}
                 data-bypass>
                <i className="fa fa-settings"></i>Settings
              </a>
            </div>
          </div>
          <Filter filters={this.state.filters} onFilterSelected={this.filterIssues}/>
          <div className="issues">
            {issuesEl}
          </div>
      </div>
    );
  }
})
