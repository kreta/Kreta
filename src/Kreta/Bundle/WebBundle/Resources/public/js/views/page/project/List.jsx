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
import './../../../../scss/views/page/project/_list.scss';

import {connect} from 'react-redux';
import {Link} from 'react-router';
import React from 'react';
import {routeActions} from 'react-router-redux';

import Button from './../../component/Button';
import NavigableList from './../../component/NavigableList';
import ProjectPreview from './../../component/ProjectPreview';
import Warning from './../../component/Warning';

class List extends React.Component {
  static propTypes = {
    onProjectSelected: React.PropTypes.func
  };

  state = {
    selectedProject: null,
    selectedShortcut: 0,
    filteredProjects: this.props.projects
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
        this.focus();
      }, 1);
    }

    if(prevProps.projects.length != this.props.projects.length) {
      this.setState({
        selectedProject: this.props.projects.length > 0 ? this.props.projects[0] : null,
        filteredProjects: this.props.projects
      })
    }
  }

  onKeyUp(ev) {
    if (ev.which === 13) { // Enter
      this.goToShortcutLink(this.state.selectedShortcut);
      ev.stopPropagation();
    } else if (ev.which < 37 || ev.which > 40) { // Filter
      const filteredProjects = this.props.projects.filter((project) => {
        return project.name.indexOf(ev.currentTarget.value) > -1 ||
          project.organization.name.indexOf(ev.currentTarget.value) > -1;
      });
      this.setState({
        filteredProjects,
        selectedProject: filteredProjects.length > 0 ? filteredProjects[0] : null
      });
    } else {
      this.refs.navigableList.handleNavigation(ev);
    }
  }

  changeSelectedRow(index) {
    this.setState({selectedProject: this.state.filteredProjects[index]});
  }

  changeSelectedShortcut(index) {
    this.setState({selectedShortcut: index});
  }

  goToShortcutLink(index) {
    const link = `/${this.state.selectedProject.organization.slug}/${this.state.selectedProject.slug}/${this.shortcuts[index].link}`;
    this.props.dispatch(routeActions.push(link));
    this.triggerOnProjectSelected();
  }

  triggerOnProjectSelected() {
    this.props.onProjectSelected();
  }

  focus() {
    this.refs.filter.focus();
  }

  getProjectItems() {
    if (this.props.projects.length > 0) {
      const projects = this.state.filteredProjects.map((project, index) => {
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

      return <NavigableList className="project-list__list"
                     onXChanged={this.changeSelectedShortcut.bind(this)}
                     onYChanged={this.changeSelectedRow.bind(this)}
                     ref="navigableList"
                     xLength={2}
                     yLength={this.state.filteredProjects.length}>
        { projects }
      </NavigableList>;
    }

    return <div className="project-list__list">
      <Warning text="No projects found, you may want to create one">
        <Link to="/project/new">
          <Button color={"green"} onClick={this.triggerOnProjectSelected.bind(this, null)}>Create project</Button>
        </Link>
      </Warning>
    </div>;
  }

  render() {
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
          </div>
        </div>
        <input className="project-list__filter"
               onKeyUp={this.onKeyUp.bind(this)}
               placeholder="Type the project"
               ref="filter"
               type="text"/>
        {this.getProjectItems()}
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
