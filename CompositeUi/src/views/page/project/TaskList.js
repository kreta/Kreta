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

import {routes} from './../../../Routes';

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

@connect(state => ({currentProject: state.currentProject, profile: state.profile.profile}))
class TaskList extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    if (this.props.profile) {
      dispatch(CurrentProjectActions.loadFilters(this.props.profile.id));
    }

    Mousetrap.bind(Config.shortcuts.taskNew, () => {
      dispatch(
        routeActions.push(routes.task.new(params.organization, params.project))
      );
    });
    Mousetrap.bind(Config.shortcuts.projectSettings, () => {
      dispatch(
        routeActions.push(routes.project.settings(params.organization, params.project))
      );
    });
  }

  filterTasks(filters) {
    const
      {currentProject, dispatch} = this.props,
      data = {projectId: currentProject.project.id};

    filters.forEach((filter) => {
      filter.forEach((item) => {
        if (item.selected) {
          data[item.filter] = item.value;
        }
      });
    });

    dispatch(CurrentProjectActions.filterTasks(data));
  }

  selectCurrentTask(task) {
    const {dispatch, params} = this.props;

    dispatch(
      routeActions.push(routes.task.show(params.organization, params.project, task.id))
    );
  }

  hideTask() {
    const {dispatch, params} = this.props;

    dispatch(
      routeActions.push(routes.project.show(params.organization, params.project))
    );
  }

  getTasksEl() {
    const {currentProject, params} = this.props;

    return currentProject.project._tasks4hn9we.edges.map((task, index) => (
      <TaskPreview
        key={index}
        onClick={this.selectCurrentTask.bind(this, task.node)}
        selected={params.taskId === task.node.id}
        task={task.node}
      />
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
          <PageHeader
            thumbnail={
              <Thumbnail
                image={null}
                text={currentProject.project.name}
              />
            }
            title={currentProject.project.name}
          >
            <InlineLink to={routes.project.settings(params.organization, params.project)}>
              <Icon color="green" glyph={SettingsIcon} size="small"/>Settings
            </InlineLink>
            <Link to={routes.task.new(params.organization, params.project)}>
              <Button color="green">New task</Button>
            </Link>
          </PageHeader>
          <Filter
            filters={currentProject.filters}
            onFilterSelected={this.filterTasks.bind(this)}
          />
          {this.getTasksEl()}
        </ContentMiddleLayout>
        <ContentRightLayout
          isOpen={this.props.children !== null}
          onRequestClose={this.hideTask.bind(this)}
        >
          {this.props.children}
        </ContentRightLayout>
      </div>
    );
  }
}

export default TaskList;
