/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/_index';
import AddIcon from './../../../svg/add';
import ListIcon from './../../../svg/list';

import React from 'react';
import {Link} from 'react-router';

import Button from './../component/Button';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import ProjectPreview from './../component/ProjectPreview';

class Index extends React.Component {
  componentWillMount() {
    this.setState({
      user: App.currentUser,
      projects: App.collection.project
    });
  }

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

  goToShortcutLink(index, shortcut) {
    const projectId = this.state.projects.at(index).id;
    this.context.history.pushState(null, this.props.shortcuts[shortcut].path + projectId);
  }

  render() {
    const projectItems = this.state.projects.map((project, index) => {
      return <ProjectPreview key={index}
                             project={project}
                             onShortcutClick={this.goToShortcutLink.bind(this, index)}
                             onTitleClick={this.goToShortcutLink.bind(this, index, 0)}
                             shortcuts={this.props.shortcuts}/>;
    });

    return (
      <ContentMiddleLayout>
        <div className="index__message">
          Welcome to Kreta!
        </div>
        <div className="index__projects">
          <div className="section-header">
            <h3 className="section-header-title">
              Your <strong>projects</strong>
            </h3>
          </div>
          <div>
            { projectItems }
          </div>
        </div>
        <div className="index__buttons">
          <Link to="/project/new">
            <Button color="green">Create project</Button>
          </Link>
        </div>
      </ContentMiddleLayout>
    );
  }
}

export default Index;
