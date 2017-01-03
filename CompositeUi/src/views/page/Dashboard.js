/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/views/page/_dashboard.scss';

import AddIcon from './../../svg/add';

import React from 'react';
import {Link} from 'react-router';
import {connect} from 'react-redux';

import Button from './../component/Button';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import DashboardActions from './../../actions/Dashboard';
import DashboardWidget from './../component/DashboardWidget';
import FormInput from './../component/FormInput';
import Icon from './../component/Icon';
import LoadingSpinner from './../component/LoadingSpinner';
import LogoHeader from './../component/LogoHeader';
import ResourcePreview from './../component/ResourcePreview';
import {Row, RowColumn} from './../component/Grid';

@connect(state => ({dashboard: state.dashboard}))
class Dashboard extends React.Component {
  componentDidMount() {
    this.props.dispatch(DashboardActions.fetchData());
  }

  renderOrganizations() {
    return this.props.dashboard.organizations.map((organization, index) => (
      <div className="dashboard" key={index}>
        <ResourcePreview
          resource={organization.node}
          shortcuts={
            <Link to="/project/new">
              <Icon glyph={AddIcon}/>
            </Link>
          }
          type="organization"
        />
        {this.renderProjects(organization.node._projectsMDbLG.edges)}
        {this.renderViewMore(organization.node)}
      </div>
    ));
  }

  renderProjects(projects) {
    return projects.map((project, index) => (
      <ResourcePreview format="child" key={index} resource={project.node} type="project"/>
    ));
  }

  renderViewMore(organization) {
    if (false === organization._projectsMDbLG.pageInfo.hasNextPage) {
      return;
    }

    return (
      <div className="resource-preview resource-preview--grand-child">
        <Link to={`/organization/${organization.id}`}>
          <div className="resource-preview__title">
            View more...
          </div>
        </Link>
      </div>
    );
  }

  render() {
    if (this.props.dashboard.fetching) {
      return <LoadingSpinner/>;
    }

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
          <RowColumn>
            <DashboardWidget
              actions={
                <Link to="/organization/new">
                  <Button color="green" size="small">New organization</Button>
                </Link>
              }
              title={<strong>Overview</strong>}>
            </DashboardWidget>
          </RowColumn>
        </Row>
        <Row>
          <RowColumn medium={8}>
            {this.renderOrganizations()}
          </RowColumn>
        </Row>
      </ContentMiddleLayout>
    );
  }
}

export default Dashboard;
