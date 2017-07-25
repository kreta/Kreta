/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/compositions/_projects.scss';

import {Link} from 'react-router';
import React from 'react';

import {routes} from './../../Routes';

import CardExtended from './../component/CardExtended';
import Section from './../component/Section';
import SectionHeader from './../component/SectionHeader';
import Thumbnail from './../component/Thumbnail';

class Projects extends React.Component {
  static propTypes = {
    organization: React.PropTypes.object.isRequired,
  };

  noProjects() {
    return (
      <p className="projects__no-project-sentence">
        No projects found, you may want to create the first one so, please
        click on "<strong>NEW PROJECT</strong>" green button.
      </p>
    );
  }

  getProjects() {
    const {organization} = this.props;

    if (organization._projects2TvKxM.edges.length === 0) {
      return this.noProjects();
    }

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

  render() {
    return (
      <div className="projects">
        <Section header={this.renderHeader()}>
          <div className="projects__table">
            {this.getProjects()}
          </div>
        </Section>
      </div>
    );
  }
}

export default Projects;
