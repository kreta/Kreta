/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import SettingsIcon from './../../../svg/settings';

import React from 'react';
import {connect} from 'react-redux';
import {Link} from 'react-router';

import {routes} from './../../../Routes';

import Button from './../../component/Button';
import Icon from './../../component/Icon';
import InlineLink from './../../component/InlineLink';
import LoadingSpinner from './../../component/LoadingSpinner';
import PageHeader from './../../component/PageHeader';
import Thumbnail from './../../component/Thumbnail';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import CurrentOrganizationActions from './../../../actions/CurrentOrganization';

@connect(state => ({currentOrganization: state.currentOrganization}))
class Show extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;
    dispatch(CurrentOrganizationActions.fetchOrganization(params.organization));
  }

  render() {
    const {currentOrganization} = this.props;
    if (currentOrganization.fetching) {
      return <LoadingSpinner/>;
    }

    return (
      <ContentMiddleLayout>
        <PageHeader
          thumbnail={
            <Thumbnail
              image={null}
              text={currentOrganization.organization.name}
            />
          }
          title={currentOrganization.organization.name}
        >
            <Icon color="green" glyph={SettingsIcon} size="small"/>Settings
          <InlineLink to={routes.organization.settings(currentOrganization.organization.slug)}>
          </InlineLink>
          <Link to={routes.project.new(currentOrganization.organization.slug)}>
            <Button color="green">New project</Button>
          </Link>
        </PageHeader>
      </ContentMiddleLayout>
    );
  }
}

export default Show;
