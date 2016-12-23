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
import {connect} from 'react-redux';
import {routeActions} from 'react-router-redux';
import {Link} from 'react-router';

import Config from './../../../Config';

import Button from './../../component/Button';
import Icon from './../../component/Icon';
import Filter from './../../component/Filter';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import TaskPreview from './../../component/TaskPreview';
import LoadingSpinner from './../../component/LoadingSpinner';
import PageHeader from './../../component/PageHeader';
import Thumbnail from './../../component/Thumbnail';
import InlineLink from './../../component/InlineLink';
import CurrentProjectActions from './../../../actions/CurrentProject';

@connect(state => ({currentProject: state.currentProject}))
class TaskList extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;
    Mousetrap.bind(Config.shortcuts.taskNew, () => {
      dispatch(
        routeActions.push(`/project/${params.projectId}/task/new`)
      );
    });
    Mousetrap.bind(Config.shortcuts.projectSettings, () => {
      dispatch(
        routeActions.push(`/project/${params.projectId}/settings`)
      );
    });
  }

  filterTasks(filters) {
    const data = {project: this.state.project.id};

    filters.forEach((filter) => {
      filter.forEach((item) => {
        if (item.selected) {
          data[item.filter] = item.value;
        }
      });
    });

    this.props.dispatch(CurrentProjectActions.filterTasks(data));
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
//      priorities = [], //project.get('task_priorities'),
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

  selectCurrentTask(task) {
    const {dispatch, params} = this.props;
    dispatch(
      routeActions.push(`/project/${params.projectId}/task/${task.id}`)
    );
  }

  hideTask() {
    const {dispatch, params} = this.props;
    dispatch(
      routeActions.push(`/project/${params.projectId}`)
    );
  }

  getTasksEl() {
    const {currentProject, params} = this.props;

    return currentProject.project._tasks4hn9we.edges.map((task, index) => (
      <TaskPreview key={index}
                   onClick={this.selectCurrentTask.bind(this, task.node)}
                   selected={params.taskId === task.node.id}
                   task={task.node}/>
    ));
  }

  render() {
    const {currentProject, params} = this.props;
    if (currentProject.waiting) {
      return <LoadingSpinner/>;
    }
    return (
      <div>
        <ContentMiddleLayout>
          <PageHeader thumbnail={<Thumbnail image={null}
                                            text={currentProject.project.name}/>}
                      title={currentProject.project.name}>
            <InlineLink to={`/project/${currentProject.project.id}/settings`}>
              <Icon color="green" glyph={SettingsIcon} size="small"/>Settings
            </InlineLink>
            <Link to={`/project/${params.projectId}/task/new`}>
              <Button color="green">New task</Button>
            </Link>
          </PageHeader>
          <Filter filters={currentProject.filters}
                  onFilterSelected={this.filterTasks.bind(this)}/>
          {this.getTasksEl()}
        </ContentMiddleLayout>
        <ContentRightLayout isOpen={this.props.children !== null}
                            onRequestClose={this.hideTask.bind(this)}>
          {this.props.children}
        </ContentRightLayout>
      </div>
    );
  }
}

export default TaskList;
