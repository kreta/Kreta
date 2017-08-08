/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {Link} from 'react-router';
import React from 'react';

import {routes} from './../../Routes';

import CardExtended from './../component/CardExtended';
import DashboardWidget from './../component/DashboardWidget';
import Thumbnail from './../component/Thumbnail';

class LastUpdatedProjectsDashboardWidget extends React.Component {
  static propTypes = {
    projects: React.PropTypes.arrayOf(React.PropTypes.object).isRequired,
  };

  renderProjects() {
    const {projects} = this.props;

    if (projects.length === 0) {
      return;
    }

    return projects.map((project, index) =>
      <Link
        key={index}
        to={routes.project.show(project.organization.slug, project.slug)}
      >
        <CardExtended
          subtitle={project.slug}
          thumbnail={<Thumbnail text={`${project.name}`} />}
          title={`${project.name}`}
        />
      </Link>,
    );
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
