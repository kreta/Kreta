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

import Button from './../../component/Button';
import NavigableList from './../../component/NavigableList';
import ProjectPreview from './../../component/ProjectPreview';

class List extends React.Component {
  static propTypes = {
    onProjectSelected: React.PropTypes.func
  };

  static contextTypes = {
    history: React.PropTypes.object
  };

  static defaultProps = {
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

  state = {
    projects: App.collection.project.clone(),
    selectedRow: 0,
    selectedShortcut: 0
  };

  onKeyUp(ev) {
    if (ev.which === 13) { // Enter
      this.goToShortcutLink();
    } else if (ev.which < 37 || ev.which > 40) { // Filter
      this.setState({
        projects: App.collection.project.filter(this.refs.filter.value),
        selectedItem: 0
      });
    } else {
      this.refs.navigableList.handleNavigation(ev);
    }
  }

  changeSelectedRow(index) {
    this.setState({
      selectedRow: index
    });
  }

  changeSelectedShortcut(index) {
    this.setState({
      selectedShortcut: index
    });
  }

  goToShortcutLink() {
    const projectId = this.state.projects.at(this.state.selectedRow).id;
    this.context.history.pushState(null, this.props.shortcuts[this.state.selectedShortcut].path + projectId);
    this.props.onProjectSelected();
  }

  onTitleClick() {
    const projectId = this.state.projects.at(this.state.selectedRow).id;
    this.context.history.pushState(null, this.props.shortcuts[0].path + projectId);
    this.props.onProjectSelected();
  }

  goToNewProjectPage() {
    this.history.pushState(null, '/project/new');
    this.props.onProjectSelected();
  }

  render() {
    const projectItems = this.state.projects.map((project, index) => {
      return <ProjectPreview key={index}
                             onMouseEnter={this.changeSelectedRow.bind(this, index)}
                             onShortcutClick={this.goToShortcutLink.bind(this)}
                             onShortcutEnter={this.changeSelectedShortcut.bind(this)}
                             onTitleClick={this.onTitleClick.bind(this)}
                             project={project}
                             selected={this.state.selectedRow === index}
                             selectedShortcut={this.state.selectedShortcut}
                             shortcuts={this.props.shortcuts}/>;
    });

    return (
      <div>
        <div className="simple-header">
          <div className="simple-header-filters">
            <span className="simple-header-filter"></span>
          </div>
          <div className="simple-header-actions">
            <Button color="green"
                    onClick={this.goToNewProjectPage}
                    size="small">
              New project
            </Button>
          </div>
        </div>
        <input className="project-list__filter"
               onKeyUp={this.onKeyUp.bind(this)}
               ref="filter"
               type="text"/>
        <NavigableList className="project-preview__list"
                       onXChanged={this.changeSelectedShortcut.bind(this)}
                       onYChanged={this.changeSelectedRow.bind(this)}
                       ref="navigableList"
                       xLength={this.props.shortcuts.length}
                       yLength={projectItems.length}>
          { projectItems }
        </NavigableList>
      </div>
    );
  }
}

export default List;
