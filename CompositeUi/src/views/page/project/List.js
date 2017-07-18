/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/project/_list.scss';

import AddIcon from './../../../svg/add.svg';
import ListIcon from './../../../svg/list.svg';

import {connect} from 'react-redux';
import React from 'react';
import {routeActions} from 'react-router-redux';

import {routes} from './../../../Routes';

import MainMenuActions from './../../../actions/MainMenu';

import Icon from './../../component/Icon';
import NavigableList from './../../component/NavigableList';
import NavigableListItemLink from './../../component/NavigableListItemLink';
import CardMinimal from './../../component/CardMinimal';
import ShortcutHelp from './../../component/ShortcutHelp';
import {Row, RowColumn} from './../../component/Grid';

@connect(state => ({projects: state.projects.projects, mainMenu: state.mainMenu}))
class List extends React.Component {
  static propTypes = {
    onProjectSelected: React.PropTypes.func
  };

  state = {
    filter: '',
    filteredProjects: []
  };

  componentWillMount() {
    this.filterProjects('');
  }

  componentWillUpdate() {
    this.focus();
  }

  onKeyUp(event) {
    if (event.which === 13) { // Enter
      this.refs.navigableList.handleNavigation(event);
    } else if (event.which === 27) { // Escape
      this.hideProjectsList();
    } else if (event.which < 37 || event.which > 40) { // Filter
      this.filterProjects(event.currentTarget.value);
    } else {
      this.refs.navigableList.handleNavigation(event);
    }

    event.stopPropagation();
  }

  hideProjectsList() {
    this.props.dispatch(MainMenuActions.hideProjects());
  }

  filterProjects(value) {
    const filteredProjects = this.props.projects.filter(project => (
      value.length === 0 || project.name.indexOf(value) > -1
    ));
    this.setState({
      filteredProjects,
    });
  }

  triggerOnProjectSelected(x, y, link) {
    this.props.dispatch(routeActions.push(link));
  }

  focus() {
    this.refs.filter.focus();
  }

  getHeader() {
    return (
      <div className="project-list__header">
        <Row>
          <RowColumn>
            <ShortcutHelp does="to select action" keyboard="← →"/>
            <ShortcutHelp does="to select project" keyboard="↑ ↓"/>
            <ShortcutHelp does="go to project" keyboard="↵"/>
            <ShortcutHelp does="to dismiss" keyboard="esc"/>
          </RowColumn>
        </Row>
      </div>
    );
  }

  getProjectItems() {
    return this.state.filteredProjects.map((project, index) => (
      <CardMinimal
        key={index}
        title={project.name}
        to={routes.project.show(project.organization.slug, project.slug)}>
          <NavigableListItemLink index={0} to={routes.project.show(project.organization.slug, project.slug)}>
            <Icon glyph={ListIcon}/>
          </NavigableListItemLink>
          <NavigableListItemLink index={1} to={routes.task.new(project.organization.slug, project.slug)}>
            <Icon glyph={AddIcon}/>
          </NavigableListItemLink>
      </CardMinimal>
    ));
  }

  render() {
    return (
      <div>
        {this.getHeader()}
        <input
          className="project-list__filter"
          onKeyUp={this.onKeyUp.bind(this)}
          placeholder="Type the project"
          ref="filter"
          type="text"
        />
        <NavigableList
          className="project-list__navigable"
          onElementSelected={this.triggerOnProjectSelected.bind(this)}
          ref="navigableList"
        >
          {this.getProjectItems()}
        </NavigableList>
      </div>
    );
  }
}

export default List;
