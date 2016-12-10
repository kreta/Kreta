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

import Button from './../component/Button';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import DashboardActions from './../../actions/Dashboard';
import DashboardWidget from './../component/DashboardWidget';
import FormInput from './../component/FormInput';
import LoadingSpinner from './../component/LoadingSpinner';
import LogoHeader from './../component/LogoHeader';
import ResourcePreview from './../component/ResourcePreview';
import {Row, RowColumn} from './../component/Grid';

@connect(state => ({
  waiting: state.dashboard.fetching,
  organizations: state.dashboard.organizations,
  projects: state.dashboard.projects
}))
class Dashboard extends React.Component {
  componentDidMount() {
    const {dispatch} = this.props;

    dispatch(DashboardActions.fetchData());
  }

  render() {
    if (this.props.waiting) {
      return <LoadingSpinner/>;
    }

    const
      organizationItems = this.props.organizations.map((organization, index) => (
        <ResourcePreview key={index} resource={organization.node} type="organization"/>
      )),
      projectItems = this.props.projects.map((project, index) => (
        <ResourcePreview key={index} resource={project.node} type="project"/>
      ));

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
            <DashboardWidget
              actions={<Link to="/organization/new">
                <Button color="green" size="small">Create org.</Button>
              </Link>}
              title={<span>Your <strong>organizations</strong></span>}>
              {organizationItems}
            </DashboardWidget>
          </RowColumn>
          <RowColumn medium={6}>
            <DashboardWidget
              actions={<Link to="/project/new">
                <Button color="green" size="small">Create project</Button>
              </Link>}
              title={<span>Your <strong>projects</strong></span>}>
              {projectItems}
            </DashboardWidget>
          </RowColumn>
        </Row>
      </ContentMiddleLayout>
    );
  }
}

export default Dashboard;
