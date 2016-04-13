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
import { connect } from 'react-redux';

import CurrentOrganizationActions from '../../../actions/CurrentOrganization';

export default class OrganizationRoot extends React.Component {
  componentDidMount() {
    this.props.dispatch(CurrentOrganizationActions.fetchOrganization(this.props.params.organization));
  }

  componentDidUpdate(prevProps) {
    const oldOrganization = prevProps.params.organization,
      newOrganization = this.props.params.organization;

    if (newOrganization !== oldOrganization) {
      this.props.dispatch(CurrentOrganizationActions.fetchOrganization(newOrganization));
    }
  }

  render() {
    return (
      this.props.children
    );
  }
}

const mapStateToProps = (state) => {
  return {};
};

export default connect(mapStateToProps)(OrganizationRoot);
