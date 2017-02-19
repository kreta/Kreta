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
import PageHeader from './../../component/PageHeader';
import Thumbnail from './../../component/Thumbnail';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import CurrentOrganizationActions from './../../../actions/CurrentOrganization';

@connect(state => ({currentOrganization: state.currentOrganization}))
class Show extends React.Component {
  componentDidMount() {
    const {params, dispatch} = this.props;
    dispatch(CurrentOrganizationActions.fetchOrganization(params.slug));
  }

  render() {
    return (
      <ContentMiddleLayout>
        <PageHeader
          thumbnail={
            <Thumbnail
              image={null}
              text={this.props.currentOrganization.organization.name}
            />
          }
          title={this.props.currentOrganization.organization.name}
        />
      </ContentMiddleLayout>
    );
  }
}

export default Show;
