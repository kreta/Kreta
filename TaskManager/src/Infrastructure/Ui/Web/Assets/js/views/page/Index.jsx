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
import {connect} from 'react-redux';

import LogoFullIcon from './../../../svg/logo-full.svg';

import Button from './../component/Button';
import Icon from './../component/Icon';
import DashboardWidget from './../component/DashboardWidget';
import FormInput from './../component/FormInput';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import ProjectPreview from './../component/ProjectPreview';
import {Row, RowColumn} from './../component/Grid';

@connect(state => ({projects: state.projects.projects}))
export default class extends React.Component {
  render() {
    const projectItems = this.props.projects.map((project, index) => {
      return <ProjectPreview key={index}
                             project={project}/>;
    });

    return (
      <ContentMiddleLayout>
        <div className="index__logo">
          <Icon glyph={LogoFullIcon}/>
        </div>
        <Row>
          <RowColumn>
            <Link to="/search">
              <FormInput label="Search..." input={{value: ''}} meta={{touched: false, errors: false}}/>
            </Link>
          </RowColumn>
        </Row>
        <Row>
          <RowColumn medium={6}>
            <DashboardWidget title={<span>Your <strong>projects</strong></span>}
                             actions={<Link to="/project/new"><Button color="green" size="small">Create project</Button></Link>}>
              { projectItems }
            </DashboardWidget>
          </RowColumn>
          <RowColumn medium={6}>
            <DashboardWidget title={<span>Your <strong>organizations</strong></span>}
                             actions={<Link to="/organization/new"><Button color="green" size="small">Create org.</Button></Link>}>
            </DashboardWidget>
          </RowColumn>
        </Row>
      </ContentMiddleLayout>
    );
  }
}
