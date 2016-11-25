/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';
import {Link} from 'react-router';
import {connect} from 'react-redux';

import ContentMiddleLayout from './../layout/ContentMiddleLayout';

import Button from './../component/Button';
import DashboardWidget from './../component/DashboardWidget';
import FormInput from './../component/FormInput';
import LogoHeader from './../component/LogoHeader';
import ProjectPreview from './../component/ProjectPreview';
import {Row, RowColumn} from './../component/Grid';

@connect(state => ({projects: state.projects.projects}))
export default class extends React.Component {
  render() {
    const projectItems = this.props.projects.map((project, index) => (<ProjectPreview key={index} project={project}/>));

    return (
      <ContentMiddleLayout>
        <LogoHeader/>
        <Row>
          <RowColumn>
            <Link to="/search">
              <FormInput input={{value: ''}} label="Search..." meta={{touched: false, errors: false}}/>
            </Link>
          </RowColumn>
        </Row>
        <Row>
          <RowColumn medium={6}>
            <DashboardWidget title={<span>Your <strong>projects</strong></span>}
                             actions={<Link to="/project/new">
                               <Button color="green" size="small">Create project</Button>
                             </Link>}>
              { projectItems }
            </DashboardWidget>
          </RowColumn>
          <RowColumn medium={6}>
            <DashboardWidget title={<span>Your <strong>organizations</strong></span>}
                             actions={<Link to="/organization/new">
                               <Button color="green" size="small">Create org.</Button>
                             </Link>}>
            </DashboardWidget>
          </RowColumn>
        </Row>
      </ContentMiddleLayout>
    );
  }
}
