/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import AddIcon from './../../svg/add.svg';

import {Link} from 'react-router';
import React from 'react';

import {routes} from './../../Routes';

import CardExtended from './../component/CardExtended';
import DashboardWidget from './../component/DashboardWidget';
import Icon from './../component/Icon';
import Thumbnail from './../component/Thumbnail';

class OrganizationsDashboardWidget extends React.Component {
  static propTypes = {
    organizations: React.PropTypes.arrayOf(React.PropTypes.object).isRequired,
  };

  renderOrganizations() {
    const {organizations} = this.props;

    return organizations.map((organization, index) =>
      <Link key={index} to={routes.organization.show(organization.slug)}>
        <CardExtended
          subtitle={organization.slug}
          thumbnail={<Thumbnail text={`${organization.name}`} />}
          title={`${organization.name}`}
        >
          {this.renderOrganizationActions(organization)}
        </CardExtended>
      </Link>,
    );
  }

  renderOrganizationActions(organization) {
    return organization.owners.map((owner, index) => {
      if (owner.id) {
        return (
          <Link key={index} to={routes.project.new(organization.slug)}>
            <Icon glyph={AddIcon} />
          </Link>
        );
      }
    });
  }

  render() {
    return (
      <DashboardWidget>
        {this.renderOrganizations()}
      </DashboardWidget>
    );
  }
}

export default OrganizationsDashboardWidget;
