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

import debounce from 'lodash.debounce';
import {connect} from 'react-redux';
import {Link} from 'react-router';
import React from 'react';
import {routeActions} from 'react-router-redux';

import DashboardActions from './../../actions/Dashboard';

import {routes} from './../../Routes';

import AssignedTasksDashboardWidget from './../composition/AssignedTasksDashboardWidget';
import Button from './../component/Button';
import ContentLayout from './../layout/ContentLayout';
import ContentMiddleLayout from './../layout/ContentMiddleLayout';
import LastUpdatedProjectsDashboardWidget from './../composition/LastUpdatedProjectsDashboardWidget';
import MyOrganizationsDashboardWidget from './../composition/MyOrganizationsDashboardWidget';
import PageHeader from './../component/PageHeader';
import Search from './../component/Search';
import Table from './../component/Table';

@connect(state => ({profile: state.profile.profile, dashboard: state.dashboard}))
class Dashboard extends React.Component {
  constructor(props) {
    super(props);

    this.debouncedOnChangeSearch = debounce((query) => {
      this.filterOrganizations(query);
      props.dispatch(routeActions.push(routes.search(query)));
    }, 200);
    this.onChangeSearch = this.onChangeSearch.bind(this);
  }

  filterOrganizations(query) {
    const {dispatch} = this.props;

    dispatch(DashboardActions.fetchData(query));
  }

  onChangeSearch(event) {
    const query = event.target ? event.target.value : null;

    this.debouncedOnChangeSearch(query);
  }

  searchQuery() {
    const {dashboard, location} = this.props;

    if (typeof location.query.q !== 'undefined') {
      if ((!dashboard.searchQuery
          || dashboard.searchQuery.length === 0
        )
        && location.query.q.length > 0
      ) {
        return location.query.q;
      }
    }

    return dashboard.searchQuery;
  }

  assignedTasks() {
    const {dashboard} = this.props;

    return dashboard.assignedTasks;
  }

  lastUpdatedProjects() {
    const {dashboard} = this.props;

    return dashboard.lastUpdatedProjects;
  }

  myOrganizations() {
    const {dashboard} = this.props;

    return dashboard.myOrganizations;
  }

  render() {
    return (
      <ContentLayout>
        <ContentMiddleLayout>
          <div className="dashboard">
            <section className="dashboard__search">
              <Search
                onChange={this.onChangeSearch}
                query={this.searchQuery()}
              />
            </section>
            <section className="dashboard__content">
              <PageHeader thumbnail={null} title="Overview">
                <Link to={routes.organization.new()}>
                  <Button color="green" size="small">New organization</Button>
                </Link>
              </PageHeader>
              <Table
                columns={2}
                headers={['Assigned tasks', 'Last updated projects', 'My organizations']}
                items={[
                  <AssignedTasksDashboardWidget tasks={this.assignedTasks()}/>,
                  <LastUpdatedProjectsDashboardWidget projects={this.lastUpdatedProjects()}/>,
                  <MyOrganizationsDashboardWidget organizations={this.myOrganizations()}/>,
                ]}
              />
            </section>
          </div>
        </ContentMiddleLayout>
      </ContentLayout>
    );
  }
}

export default Dashboard;
