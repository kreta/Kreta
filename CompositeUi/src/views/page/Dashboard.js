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
import {routeActions} from 'react-router-redux';

import DashboardActions from './../../actions/Dashboard';

import {routes} from './../../Routes';

import Button from './../component/Button';
import CardMinimal from './../component/CardMinimal';
import CardExtended from './../component/CardExtended';
import DashboardWidget from './../component/DashboardWidget';
import Icon from './../component/Icon';
import LoadingSpinner from './../component/LoadingSpinner';
import {Row, RowColumn} from './../component/Grid';
import Search from '../component/Search';
import Thumbnail from '../component/Thumbnail';

@connect(state => ({profile: state.profile.profile, dashboard: state.dashboard}))
class Dashboard extends React.Component {
  constructor(props) {
    super(props);

    this.filterOrganizations = debounce(this.filterOrganizations, 200);
  }

  componentDidMount() {
    this.filterOrganizations(this.props.location.query.q);
  }

  filterOrganizations(query) {
    this.props.dispatch(DashboardActions.fetchData(query));
  }

  onChangeSearch(event) {
    const query = event.target.value;

    this.props.dispatch(routeActions.push(routes.search(query)));
    this.filterOrganizations(query);
  }

  searchQuery() {
    const {dashboard, location} = this.props;

    if (typeof location.query.q !== 'undefined') {
      if ((typeof dashboard.searchQuery === 'undefined' || dashboard.searchQuery.length === 0)
        && location.query.q.length > 0
      ) {
        return location.query.q;
      }
    }

    return dashboard.searchQuery;
  }

  renderOrganizations() {
    const {dashboard} = this.props;

    return dashboard.organizations.map((organization, index) => (
      <div className="dashboard" key={index}>
        <CardMinimal title={organization.node.name}
                     to={routes.organization.show(organization.node.slug)}>
          {this.renderProjectCreateLink(organization.node)}
        </CardMinimal>
        {this.renderProjects(organization.node._projectsMDbLG.edges)}
        {this.renderViewMore(organization.node)}
      </div>
    ));
  }

  renderProjectCreateLink(organization) {
    const
      {profile} = this.props,
      profileId = profile.user_id;

    return organization.owners.map((owner, index) => {
      if (owner.id === profileId) {
        return (
          <Link key={index} to={routes.project.new(organization.slug)}>
            <Icon glyph={AddIcon}/>
          </Link>
        );
      }
    });
  }

  renderProjects(projects) {
    return projects.map((project, index) => (
      <Link key={index} to={routes.project.show(project.node.organization.slug, project.node.slug)}>
        <CardExtended
          subtitle={project.node.slug}
          thumbnail={<Thumbnail text={`${project.node.name}`}/>}
          title={`${project.node.name}`}
        />
      </Link>
    ));
  }

  renderViewMore(organization) {
    if (false === organization._projectsMDbLG.pageInfo.hasNextPage) {
      return;
    }

    return (
      <Link className="dashboard__view-more" to={routes.organization.show(organization.slug)}>
        View more...
      </Link>
    );
  }

  render() {
    const {dashboard} = this.props;

    return (
      <article className="dashboard">
        <Row className="dashboard__search">
          <RowColumn>
            <Search
              onChange={this.onChangeSearch.bind(this)}
              query={this.searchQuery()}
            />
          </RowColumn>
        </Row>
        <Row>
          <RowColumn medium={6}>
            <DashboardWidget
              actions={
                <Link to={routes.organization.new()}>
                  <Button color="green" size="small">New organization</Button>
                </Link>
              }
              title={<strong>Overview</strong>}
            />
            {dashboard.fetching ? <LoadingSpinner/> : this.renderOrganizations()}
          </RowColumn>
        </Row>
      </article>
    );
  }
}

export default Dashboard;
