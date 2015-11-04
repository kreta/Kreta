/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import AddIcon from './../../../../svg/add.svg';
import ListIcon from './../../../../svg/list.svg';

import React from 'react';
import {History} from 'react-router';
import $ from 'jquery';

import NavigableCollection from '../../../mixins/NavigableCollection.js';
import ProjectPreview from '../../component/ProjectPreview';
import Button from '../../component/Button.js';

export default React.createClass({
  propTypes: {
    onProjectSelected: React.PropTypes.func
  },
  mixins: [History, NavigableCollection],
  getInitialState() {
    return {
      projects: App.collection.project.clone(),
      selectedShortcut: 0
    };
  },
  getDefaultProps() {
    return {
      shortcuts: [{
        'icon': ListIcon,
        'path': '/project/',
        'tooltip': 'Show full project'
      }, {
        'icon': AddIcon,
        'path': '/issue/new/',
        'tooltip': 'New task'
      }]
    };
  },
  onKeyUp(ev) {
    if (ev.which === 37) { // Left
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
    } else if (ev.which === 13) { // Enter
      this.onShortcutClick();
    } else if (ev.which !== 38 && ev.which !== 40) { // Filter
      this.setState({
        projects: App.collection.project.filter(this.refs.filter.value),
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
  onTitleClick() {
    const projectId = this.state.projects.at(this.state.selectedItem).id;
    this.history.pushState(null, this.props.shortcuts[0].path + projectId);
    this.props.onProjectSelected();
  },
  goToNewProjectPage() {
    this.history.pushState(null, '/project/new');
    this.props.onProjectSelected();
  },
  render() {
    var projectItems = this.state.projects.map((project, index) => {
      return <ProjectPreview key={index}
                             onMouseEnter={this.onMouseEnter}
                             onShortcutClick={this.onShortcutClick}
                             onShortcutEnter={this.onShortcutSelected}
                             onTitleClick={this.onTitleClick}
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
            <Button color="green" size="small"
                    onClick={this.goToNewProjectPage}>
              New
            </Button>
          </div>
        </div>
        <input className="project-list__filter"
               onKeyUp={this.onKeyUp}
               ref="filter"
               type="text"/>
        <ul className="project-preview__list" ref="navigableList">
          { projectItems }
        </ul>
      </div>
    );
  }
});
