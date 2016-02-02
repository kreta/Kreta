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

import Button from './../../component/Button';
import NavigableList from './../../component/NavigableList';
import ProjectPreview from './../../component/ProjectPreview';

class List extends React.Component {
  static propTypes = {
    onProjectSelected: React.PropTypes.func
  };

  state = {
    selectedProject: null,
    selectedShortcut: 0
  };

  shortcuts = [{
    'icon': ListIcon,
    'link': '',
    'tooltip': 'Show full project'
  }, {
    'icon': AddIcon,
    'link': '/issue/new/',
    'tooltip': 'New task'
  }];

  componentDidUpdate(prevProps) {
    if (prevProps.projectsVisible === false && this.props.projectsVisible) {
      setTimeout(() => {
        this.focus()
      }, 1);
    }
  }

  onKeyUp(ev) {
    if (ev.which === 13) { // Enter
      this.goToShortcutLink(this.state.selectedShortcut);
      ev.stopPropagation();
    } else if (ev.which < 37 || ev.which > 40) { // Filter
      // dispatch filter action
    } else {
      this.refs.navigableList.handleNavigation(ev);
    }
  }

  changeSelectedRow(index) {
    this.setState({selectedProject: this.props.projects[index]});
  }

  changeSelectedShortcut(index) {
    this.setState({selectedShortcut: index});
  }

  goToShortcutLink(index) {
    const link = `/project/${this.state.selectedProject.id}/${this.shortcuts[index].link}`;
    this.props.dispatch(routeActions.push(link));
    this.triggerOnProjectSelected();
  }

  triggerOnProjectSelected() {
    this.props.onProjectSelected();
  }

  focus() {
    this.refs.filter.focus();
  }

  render() {
    const projectItems = this.props.projects.map((project, index) => {
      return <ProjectPreview key={index}
                             onMouseEnter={this.changeSelectedRow.bind(this, index)}
                             onShortcutClick={this.goToShortcutLink.bind(this)}
                             onShortcutEnter={this.changeSelectedShortcut.bind(this)}
                             onTitleClick={this.triggerOnProjectSelected.bind(this, project)}
                             project={project}
                             selected={this.state.selectedProject && this.state.selectedProject.id === project.id}
                             selectedShortcut={this.state.selectedShortcut}
                             shortcuts={this.shortcuts}/>;
    });

    return (
      <div>
        <div className="simple-header">
          <div className="simple-header__actions">
            <div className="simple-header__action">
              <span className="simple-header__action-key">← →</span>navigate between actions
            </div>
            <div className="simple-header__action">
              <span className="simple-header__action-key">↑ ↓</span>navigate between projects
            </div>
            <div className="simple-header__action">
              <span className="simple-header__action-key">↵</span>to select
            </div>
            <div className="simple-header__action">
              <span className="simple-header__action-key simple-header__action-key--escape">esc</span>to dismiss
            </div>
            <Link to="/project/new">
              <Button color="green"
                      onClick={this.triggerOnProjectSelected.bind(this, null)}
                      size="small">
                New project
              </Button>
            </Link>
          </div>
        </div>
        <input className="project-preview__filter"
               onKeyUp={this.onKeyUp.bind(this)}
               placeholder="Type the project"
               ref="filter"
               type="text"/>
        <NavigableList className="project-preview__list"
                       onXChanged={this.changeSelectedShortcut.bind(this)}
                       onYChanged={this.changeSelectedRow.bind(this)}
                       ref="navigableList"
                       xLength={2}
                       yLength={projectItems.length}>
          { projectItems }
        </NavigableList>
      </div>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    projects: state.projects.projects,
    projectsVisible: state.mainMenu.projectsVisible
  };
};

export default connect(mapStateToProps)(List);
