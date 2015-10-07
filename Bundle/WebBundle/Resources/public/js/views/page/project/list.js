/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */
import React from 'react';
import {Link, History} from 'react-router';

import ProjectPreview from '../../component/projectPreview';

export default React.createClass({
  propTypes: {
    onProjectSelected: React.PropTypes.func
  },
  mixins: [History],
  getInitialState() {
    return {
      projects: App.collection.project.clone(),
      selectedItem: 0,
      selectedShortcut: 0
    };
  },
  getDefaultProps() {
    return {
      shortcuts: [{
        'icon': 'list',
        'path': '/project/',
        'tooltip': 'Show full project'
      }, {
        'icon': 'add',
        'path': '/issue/new/',
        'tooltip': 'New task'
      }]
    };
  },
  onKeyUp(ev) {
    if (ev.which === 40) { // Down
      if (this.state.selectedItem + 1 < this.state.projects.length) {
        this.setState({
          selectedItem: this.state.selectedItem + 1
        });
        this.centerListScroll();
      }

    } else if (ev.which === 38) { // Up
      if (this.state.selectedItem > 0) {
        this.setState({
          selectedItem: this.state.selectedItem - 1
        });
        this.centerListScroll();
      }
    } else if (ev.which === 37) { // Left
      if (this.state.selectedShortcut > 0) {
        this.setState({
          selectedShortcut: this.state.selectedShortcut - 1
        });
      }
    } else if (ev.which === 39) { // Right
      if (this.state.selectedShortcut + 1 < this.props.shortcuts.length) {
        this.setState({
          selectedShortcut: this.state.selectedShortcut + 1
        });
      }
    } else { // Filter
      this.setState({
        projects: App.collection.project.filter(this.refs.filter.getDOMNode().value),
        selectedItem: 0
      });
    }
  },
  onMouseEnter(ev) {
    this.setState({
      selectedItem: $(ev.currentTarget).index()
    });
  },
  onShortcutSelected(ev) {
    this.setState({
      selectedShortcut: $(ev.currentTarget).index()
    });
  },
  onShortcutClick() {
    const projectId = this.state.projects.at(this.state.selectedItem).id;
    this.history.pushState(null, this.props.shortcuts[this.state.selectedShortcut].path + projectId);
    this.props.onProjectSelected();
  },
  centerListScroll() {
    this.refs.projectList.getDOMNode().scrollTop = this.state.selectedItem * 60 - 60 * 2;
  },
  render() {
    var projectItems = this.state.projects.map((project, index) => {
      return <ProjectPreview key={index}
                             onMouseEnter={this.onMouseEnter}
                             onShortcutClick={this.onShortcutClick}
                             onShortcutEnter={this.onShortcutSelected}
                             project={project}
                             selected={this.state.selectedItem === index}
                             selectedShortcut={this.state.selectedShortcut}
                             shortcuts={this.props.shortcuts}/>;
    });

    return (
      <div>
        <div className="simple-header">
          <div className="simple-header-filters">
            <span className="simple-header-filter">Sort by <strong>priority</strong></span>
          </div>
          <div className="simple-header-actions">
            <Link className="button green small" to="/project/new">New</Link>
          </div>
        </div>
        <input className="project-list__filter"
               onKeyUp={this.onKeyUp}
               ref="filter"
               type="text"/>
        <ul className="project-preview__list" ref="projectList">
          { projectItems }
        </ul>
      </div>
    );
  }
});
