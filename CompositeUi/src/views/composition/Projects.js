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

import Advice from './../component/Advice';
import CardExtended from './../component/CardExtended';
import Section from './../component/Section';
import SectionHeader from './../component/SectionHeader';
import Table from './../component/Table';
import Thumbnail from './../component/Thumbnail';

class Projects extends React.Component {
  static propTypes = {
    organization: React.PropTypes.object.isRequired,
  };

  noProjects() {
    return (
      <Advice>
        No projects found, you may want to create the first one so, please
        click on "<strong>NEW PROJECT</strong>" green button.
      </Advice>
    );
  }

  getProjects() {
    const {organization} = this.props;

    return organization._projects2TvKxM.edges.map((project, index) => {
      const currentProject = project.node;

      return (
        <Link key={index} to={routes.project.show(organization.slug, currentProject.slug)}>
          <CardExtended
            subtitle={currentProject.slug}
            thumbnail={<Thumbnail text={currentProject.name}/>}
            title={currentProject.name}
          />
        </Link>
      );
    });
  }

  renderHeader() {
    return (
      <SectionHeader title="Projects"/>
    );
  }

  renderContent() {
    const {organization} = this.props;

    if (organization._projects2TvKxM.edges.length === 0) {
      return this.noProjects();
    }

    return (
      <Table columns={3} items={this.getProjects()}/>
    );
  }

  render() {
    return (
      <div className="projects">
        <Section header={this.renderHeader()}>
          {this.renderContent()}
        </Section>
      </div>
    );
  }
}

export default Projects;
