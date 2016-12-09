/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/issue/_show';

import {connect} from 'react-redux';
import React from 'react';
import {Link} from 'react-router';

import Button from './../../component/Button';
import FormActions from './../../component/FormActions';
import LoadingSpinner from './../../component/LoadingSpinner';
import {Row, RowColumn} from './../../component/Grid';
import SelectorOption from './../../component/SelectorOption';
import Thumbnail from './../../component/Thumbnail';

@connect(state => ({issue: state.currentProject.selectedIssue}))
class Show extends React.Component {

  render() {
    const {issue, params} = this.props;
    if (!issue) {
      return <div className="issue-show"><LoadingSpinner/></div>;
    }
    return (
      <div>
        <Row>
          <RowColumn>
            <h1 className="issue-show__title">{issue.title}</h1>
            <p className="issue-show__description">{issue.description}</p>
          </RowColumn>
        </Row>
        <Row className="issue-show__fields">
          <RowColumn small={6}>
            <SelectorOption alignLeft
                            label="Assignee"
                            text={`${issue.assignee.first_name} ${issue.assignee.last_name}`}
                            thumbnail={<Thumbnail image={null}
                                                  text={`${issue.assignee.first_name} ${issue.assignee.last_name}`}/>}
                            value="1"/>
          </RowColumn>
          <RowColumn small={6}>
            <SelectorOption alignLeft label="Priority" left text="High" value="1"/>
          </RowColumn>
        </Row>
        <Row>
          <RowColumn>
            <FormActions>
              <Link to={`/project/${params.projectId}/issue/${params.issueId}/edit`}>
                <Button color="green">Edit</Button>
              </Link>
            </FormActions>
          </RowColumn>
        </Row>
      </div>
    );
  }
}

export default Show;
