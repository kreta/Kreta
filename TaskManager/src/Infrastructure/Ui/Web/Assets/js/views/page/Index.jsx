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

import React from 'react';
import {Link} from 'react-router';
import { connect } from 'react-redux';

import Button from './../component/Button';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import ProjectPreview from './../component/ProjectPreview';

@connect(state => ({projects: state.projects.projects}))
export default class extends React.Component {
  render() {
    const projectItems = this.props.projects.map((project, index) => {
      return <ProjectPreview key={index}
                             project={project}/>;
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
