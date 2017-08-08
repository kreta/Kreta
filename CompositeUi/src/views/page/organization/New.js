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
import {connect} from 'react-redux';

import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import OrganizationNew from './../../form/OrganizationNew';
import OrganizationActions from './../../../actions/Organization';

@connect()
class New extends React.Component {
  createOrganization(organization) {
    this.props.dispatch(OrganizationActions.createOrganization(organization));
  }

  render() {
    return (
      <ContentMiddleLayout centered>
        <OrganizationNew onSubmit={this.createOrganization.bind(this)} />
      </ContentMiddleLayout>
    );
  }
}

export default New;
