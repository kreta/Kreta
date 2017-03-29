/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import SettingsIcon from './../../../svg/settings.svg';

import {connect} from 'react-redux';
import {Link} from 'react-router';
import Mousetrap from 'mousetrap';
import React from 'react';
import {routeActions} from 'react-router-redux';

import Config from './../../../Config';
import CurrentProjectActions from './../../../actions/CurrentProject';
import {routes} from './../../../Routes';

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import Filter from './../../component/Filter';
import Icon from './../../component/Icon';
import InlineLink from './../../component/InlineLink';
import LoadingSpinner from './../../component/LoadingSpinner';
import NavigableList from './../../component/NavigableList';
import PageHeader from './../../component/PageHeader';
import TaskPreview from './../../component/TaskPreview';
import Thumbnail from './../../component/Thumbnail';

@connect(state => ({currentProject: state.currentProject, profile: state.profile}))
class TaskList extends React.Component {
  componentDidMount() {
    const {dispatch, params, profile} = this.props;

    if (profile.profile) {
      dispatch(CurrentProjectActions.loadFilters(profile.profile.user_id));
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
    Mousetrap.bind(['up', 'down', 'enter'], (event) => {
      this.handleKeyboardNavigation(event);
    });
    Mousetrap.bind('esc', () => {
      this.hideTask();
    });
  }

  componentWillUnmount() {
    Mousetrap.unbind(Config.shortcuts.taskNew);
    Mousetrap.unbind(Config.shortcuts.projectSettings);
    Mousetrap.unbind(['up', 'down', 'enter']);
    Mousetrap.unbind('esc');
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
      routeActions.push(routes.task.show(params.organization, params.project, task.numeric_id))
    );
  }

  selectCurrentTaskByIndex(x, y) {
    const {currentProject} = this.props;

    this.selectCurrentTask(currentProject.project._tasks49h6f1.edges[y].node);
  }

  handleKeyboardNavigation(event) {
    this.refs.navigableList.handleNavigation(event);
  }

  hideTask() {
    const {dispatch, params} = this.props;

    dispatch(
      routeActions.push(routes.project.show(params.organization, params.project))
    );
  }

  getTasksEl() {
    const {currentProject, params} = this.props;

    return currentProject.project._tasks49h6f1.edges.map((task, index) => (
      <TaskPreview
        key={index}
        onClick={this.selectCurrentTask.bind(this, task.node)}
        selected={params.taskId === task.node.id}
        task={task.node}
      />
    ));
  }

  render() {
    const {children, currentProject, params, profile} = this.props;

    if (currentProject.waiting || profile.fetching) {
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
          <NavigableList onElementSelected={this.selectCurrentTaskByIndex.bind(this)} ref="navigableList">
            {this.getTasksEl()}
          </NavigableList>
        </ContentMiddleLayout>
        <ContentRightLayout
          isOpen={children !== null}
          onRequestClose={this.hideTask.bind(this)}
        >
          {children}
        </ContentRightLayout>
      </div>
    );
  }
}

export default TaskList;
