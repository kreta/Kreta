/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';
import {Link} from 'react-router';
import { connect } from 'react-redux';

import Button from './../../component/Button';
import NavigableList from './../../component/NavigableList';
import ProjectPreview from './../../component/ProjectPreview';
import ProjectsActions from './../../../actions/Projects'
import MainMenuActions from './../../../actions/MainMenu'

class List extends React.Component {
  static propTypes = {
    onProjectSelected: React.PropTypes.func
  };

  onKeyUp(ev) {
    if (ev.which === 13) { // Enter
      // Use refs to call selectShortcut()
    } else if (ev.which < 37 || ev.which > 40) { // Filter
      // dispatch filter action
    } else {
      this.refs.navigableList.handleNavigation(ev);
    }
  }

  changeSelectedRow(index) {
    this.props.dispatch(MainMenuActions.highlightProject(this.props.projects[index]));
  }

  changeSelectedShortcut(index) {
    // dispatch
  }

  triggerOnProjectSelected(project) {
    this.props.onProjectSelected(project);
  }

  focus() {
    this.refs.filter.focus();
  }

  render() {
    const projectItems = this.props.projects.map((project, index) => {
      return <ProjectPreview key={index}
                             onMouseEnter={this.changeSelectedRow.bind(this, index)}
                             onShortcutClick={this.triggerOnProjectSelected.bind(this, project)}
                             onShortcutEnter={this.changeSelectedShortcut.bind(this)}
                             onTitleClick={this.triggerOnProjectSelected.bind(this, project)}
                             project={project}
                             selected={this.props.highlightedProject && this.props.highlightedProject.id === project.id}
                             selectedShortcut={this.props.selectedShortcut}/>;
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
                      onClick={this.triggerOnProjectSelected.bind(this,null)}
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
    highlightedProject: state.mainMenu.highlightedProject,
    selectedShortcut: 0
  }
};

export default connect(mapStateToProps)(List);
