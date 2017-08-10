/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {connect} from 'react-redux';
import React from 'react';

import CurrentOrganizationActions from './../../../actions/CurrentOrganization';

@connect()
class Root extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;

    dispatch(CurrentOrganizationActions.fetchOrganization(params.organization));
  }

  componentDidUpdate(prevProps) {
    const {params, dispatch} = this.props;

    if (params.organization !== prevProps.params.organization) {
      dispatch(
        CurrentOrganizationActions.fetchOrganization(params.organization),
      );
    }
  }

  render() {
    return this.props.children;
  }
}

export default Root;
