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
import IssueNew from './../../form/IssueNew';
import CurrentProjectActions from './../../../actions/CurrentProject';

@connect()
class New extends React.Component {
  createIssue(issue) {
    this.props.dispatch(CurrentProjectActions.createIssue(issue));
  }

  render() {
    return (
      <ContentMiddleLayout>
        <IssueNew onSubmit={this.createIssue.bind(this)}/>
      </ContentMiddleLayout>
    );
  }
}

export default New;
