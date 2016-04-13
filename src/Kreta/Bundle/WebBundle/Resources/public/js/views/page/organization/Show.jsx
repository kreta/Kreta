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
import {Link} from 'react-router';
import { connect } from 'react-redux';

import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import Button from './../../component/Button';
import DashboardWidget from './../../component/DashboardWidget';
import Warning from './../../component/Warning';
import LoadingSpinner from './../../component/LoadingSpinner';

export default class Show extends React.Component {
  render() {
    if (this.props.organization.fetchingOrganization) {
      return <LoadingSpinner/>;
    }
    return (
      <ContentMiddleLayout>
        <div className="index__dashboard">
          <DashboardWidget title="Your projects">

          </DashboardWidget>
          <DashboardWidget title="Need more projects?">
            <Warning text="You can create a new one pressing the button bellow">
              <Link to={`${this.props.organization.organization.slug}/project/new`}>
                <Button color="green">Create project</Button>
              </Link>
            </Warning>
          </DashboardWidget>
        </div>
      </ContentMiddleLayout>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    organization: state.currentOrganization
  };
};

export default connect(mapStateToProps)(Show);
