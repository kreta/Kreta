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

import debounce from 'lodash.debounce';
import React from 'react';
import {connect} from 'react-redux';
import {Link} from 'react-router';

import DashboardActions from './../../actions/Dashboard';

import {routes} from './../../Routes';

import Button from './../component/Button';
import DashboardWidget from './../component/DashboardWidget';
import Icon from './../component/Icon';
import ResourcePreview from './../component/ResourcePreview';
import {Row, RowColumn} from './../component/Grid';
import Search from '../component/Search';

@connect(state => ({dashboard: state.dashboard}))
class Dashboard extends React.Component {
  constructor(props) {
    super(props);

    this.filterOrganizations = debounce(this.filterOrganizations, 200);
  }

  componentDidMount() {
    this.filterOrganizations(null);
  }

  filterOrganizations(query) {
    this.props.dispatch(DashboardActions.fetchData(query));
  }

  onChangeSearch(event) {
    this.filterOrganizations(event.target.value);
  }

  renderOrganizations() {
    return this.props.dashboard.organizations.map((organization, index) => (
      <div className="dashboard" key={index}>
        <ResourcePreview
          resource={organization.node}
          shortcuts={
            <Link to={routes.project.new(organization.node.slug)}>
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
        <Link to={routes.organization.show(organization.slug)}>
          <div className="resource-preview__title">
            View more...
          </div>
        </Link>
      </div>
    );
  }

  render() {
    return (
      <article className="dashboard">
        <Row className="dashboard__search">
          <RowColumn>
            <Search onChange={this.onChangeSearch.bind(this)}/>
          </RowColumn>
        </Row>
        <Row>
          <RowColumn>
            <DashboardWidget
              actions={
                <Link to={routes.organization.new()}>
                  <Button color="green" size="small">New organization</Button>
                </Link>
              }
              title={<strong>Overview</strong>}
            />
          </RowColumn>
        </Row>
        <Row>
          <RowColumn medium={8}>
            {this.renderOrganizations()}
          </RowColumn>
        </Row>
      </article>
    );
  }
}

export default Dashboard;
