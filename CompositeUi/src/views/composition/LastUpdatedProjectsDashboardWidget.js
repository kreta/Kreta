/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import AddIcon from './../../svg/add.svg';

import {Link} from 'react-router';
import React from 'react';

import {routes} from './../../Routes';

import CardExtended from './../component/CardExtended';
import DashboardWidget from './../component/DashboardWidget';
import Icon from './../component/Icon';
import Thumbnail from './../component/Thumbnail';

class LastUpdatedProjectsDashboardWidget extends React.Component {
  static propTypes = {
    projects: React.PropTypes.arrayOf(
      React.PropTypes.object
    ).isRequired,
  };

  renderProjects() {
    const {projects} = this.props;

    return projects.map((project, index) => (
      <Link key={index} to={routes.project.show(project.node.organization.slug, project.node.slug)}>
        <CardExtended
          subtitle={project.node.slug}
          thumbnail={<Thumbnail text={`${project.node.name}`}/>}
          title={`${project.node.name}`}
        >
        </CardExtended>
      </Link>
    ));
  }

  renderProjectActions(project) {
    return project.owners.map((owner, index) => (
      <Link key={index} to={routes.project.new(project.slug)}>
        <Icon glyph={AddIcon}/>
      </Link>
    ));
  }

  render() {
    return (
      <DashboardWidget>
        {this.renderProjects()}
      </DashboardWidget>
    );
  }
}

export default LastUpdatedProjectsDashboardWidget;
