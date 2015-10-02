/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {FilterView} from '../../component/filter';
import {IssuePreviewView} from '../../component/issuePreview';

export default React.createClass({
  willRecieveProps() {

  },
  componentWillMount() {
    this.props.project.on('sync', this.render);
    this.props.project.on('change', this.render);
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
      priorities = this.model.get('issue_priorities'),
      statusFilters = [{
        title: 'All statuses',
        filter: 'status',
        value: '',
        selected: true
      }],
      statuses = this.model.get('statuses');

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

    this.filters = [assigneeFilters, priorityFilters, statusFilters];
  },
  render() {
    let issues = [];
    return (
      <div>
        <div class="page-header">
          <div class="project-image" style="background: #ebebeb"></div>
          <h2 class="page-header-title">{this.props.project.name}</h2>
            <div>
              <a class="page-header-link" href="#">
                <i class="fa fa-dashboard"></i>Dashboard
              </a>
              <a id="project-settings-show"
                 class="page-header-link"
                 href={`/projects/${this.props.project.id}/settings`}
                 data-bypass>
                <i class="fa fa-settings"></i>Settings
              </a>
            </div>
          </div>
          <Filter filters={this.filters} onFilterSelected={this.filterIssues}/>
          <div class="issues">
            {issues}
          </div>
      </div>
    );
  }
})
