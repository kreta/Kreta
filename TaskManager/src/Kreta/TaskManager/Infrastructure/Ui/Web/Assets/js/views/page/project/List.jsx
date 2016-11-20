/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import AddIcon from './../../../../svg/add';
import ListIcon from './../../../../svg/list';

import React from 'react';
import {Link} from 'react-router';
import {connect} from 'react-redux';
import {routeActions} from 'react-router-redux';
import classNames from 'classnames';

import Button from './../../component/Button';
import Icon from './../../component/Icon';
import NavigableList from './../../component/NavigableList';
import ProjectPreview from './../../component/ProjectPreview';
import ShortcutHelp from './../../component/ShortcutHelp';
import {Row, RowColumn} from './../../component/Grid';

@connect(state => ({projects: state.projects.projects}))
export default class extends React.Component {
  static propTypes = {
    onProjectSelected: React.PropTypes.func
  };

  state = {
    selectedProject: 0,
    selectedShortcut: 0,
    filter: '',
    filteredProjects: []
  };

  componentWillMount() {
    this.filterProjects('');
  }

  onKeyUp(ev) {
    if (ev.which === 13) { // Enter
      this.goToShortcutLink(this.state.selectedShortcut);
    } else if (ev.which < 37 || ev.which > 40) { // Filter
      this.filterProjects(ev.currentTarget.value);
    } else {
      this.refs.navigableList.handleNavigation(ev);
    }

    ev.stopPropagation();
  }

  filterProjects(value) {
    const filteredProjects = this.props.projects.filter(project => {
      return value.length === 0 ||
        (project.name.indexOf(value) > -1 ||
        project.organization.name.indexOf(value) > -1);
    });
    this.setState({
      filteredProjects,
      selectedProject: 0
    });
  }

  changeSelectedRow(index) {
    this.setState({selectedProject: index});
  }

  changeSelectedShortcut(index) {
    this.setState({selectedShortcut: index});
  }

  goToShortcutLink(index) {
    const shortcutLinks = ['/', '/issue/new'];
    this.props.dispatch(
      routeActions.push(`/project/${this.state.filteredProjects[this.state.selectedProject].id}${shortcutLinks[index]}`)
    );
    this.triggerOnProjectSelected();
  }

  triggerOnProjectSelected() {
    this.props.onProjectSelected();
  }

  focus() {
    this.refs.filter.focus();
  }

  getHeader() {
    return (
      <div className="project-preview__header">
        <Row>
          <RowColumn small={9}>
            <ShortcutHelp keyboard="← →" does="to select action"/>
            <ShortcutHelp keyboard="↑ ↓" does="to select project"/>
            <ShortcutHelp keyboard="↵" does="go to project"/>
            <ShortcutHelp keyboard="esc" does="to dismiss"/>
          </RowColumn>
          <RowColumn small={3}>
            <Link to="/project/new">
              <Button color="green"
                      onClick={this.triggerOnProjectSelected.bind(this, null)}
                      size="small">
                New project
              </Button>
            </Link>
          </RowColumn>
        </Row>
      </div>
    );
  }

  getProjectItems()
  {
    return this.state.filteredProjects.map((project, index) => {
      return <ProjectPreview key={index}
                             project={project}
                             shortcuts={
                               <div>
                                 <Icon className={classNames({
                                   'project-preview__shortcut': true,
                                   'project-preview__shortcut--selected': 0 === this.state.selectedShortcut
                                 })}
                                       glyph={ListIcon}
                                       onClick={this.goToShortcutLink.bind(this, 0)}
                                       onMouseEnter={this.changeSelectedShortcut.bind(this, 0)}/>
                                 <Icon className={classNames({
                                   'project-preview__shortcut': true,
                                   'project-preview__shortcut--selected': 1 === this.state.selectedShortcut
                                 })}
                                       glyph={AddIcon}
                                       onClick={this.goToShortcutLink.bind(this, 1)}
                                       onMouseEnter={this.changeSelectedShortcut.bind(this, 1)}/>
                               </div>
                             }/>;

    });
  }

  render() {
    return (
      <div>
        {this.getHeader()}
        <input className="project-preview__filter"
               onKeyUp={this.onKeyUp.bind(this)}
               placeholder="Type the project"
               ref="filter"
               type="text"/>
        <NavigableList className="project-preview__list"
                       classNameSelected="project-preview--selected"
                       onElementSelected={this.triggerOnProjectSelected.bind(this)}
                       onXChanged={this.changeSelectedShortcut.bind(this)}
                       onYChanged={this.changeSelectedRow.bind(this)}
                       ref="navigableList"
                       xSelected={this.state.selectedShortcut}
                       ySelected={this.state.selectedProject}
                       xLength={2}
                       yLength={this.state.filteredProjects.length}>
          { this.getProjectItems() }
        </NavigableList>
      </div>
    );
  }
}
