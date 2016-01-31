/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../scss/views/page/issue/_new';
import PriorityIcon from './../../../../svg/priority';

import React from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import {routeActions} from 'react-router-redux';

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import Form from './../../component/Form';
import FormInput from './../../component/FormInput';
import FormSerializer from '../../../service/FormSerializer';
import Icon from './../../component/Icon';
import IssueField from './../../component/IssueField';
import Selector from './../../component/Selector';
import UserImage from './../../component/UserImage';
import LoadingSpinner from '../../component/LoadingSpinner';
import CurrentProjectActions from '../../../actions/CurrentProject';

class New extends React.Component {
  createIssue(ev) {
    ev.preventDefault();
    const issue = FormSerializer.serialize(ReactDOM.findDOMNode(this.refs.form));
    this.props.dispatch(CurrentProjectActions.createIssue(issue));
  }

  updateSelectors(projectId) {
    this.props.dispatch(routeActions.push(`/project/${projectId}/issue/new`));
  }

  getProjectOptions() {
    const project = this.props.currentProject.project;

    var selectableProjects = this.props.projects.projects.map((p) => {
        return (
          <IssueField
            text={p.name}
            value={p.id}/>
        );
      }),
      assignee = project.participants.map((p) => {
        let assigneeName = `${p.user.first_name} ${p.user.last_name}`;
        if (p.user.first_name === '' || p.user.first_name === undefined) {
          assigneeName = p.user.username;
        }

        return (
          <IssueField alignLeft={true}
                      image={<UserImage user={p.user}/>}
                      label="Assigned to"
                      text={assigneeName}
                      value={p.user.id}/>
        );
      }),
      priority = project.issue_priorities.map((p) => {
        return (
          <IssueField alignLeft={true}
                      image={
                        <Icon className="issue-field__icon"
                              glyph={PriorityIcon}
                              style={{fill: p.color}}/>
                      }
                      label="Priority"
                      text={p.name}
                      value={p.id}/>
        );
      });

    return {selectableProjects, assignee, priority};
  }

  render() {
    if (this.props.currentProject.fetching || !this.props.currentProject.project) {
      return <LoadingSpinner/>;
    }

    const options = this.getProjectOptions(),
      project = this.props.currentProject.project;

    return (
      <ContentMiddleLayout>
        <Form errors={this.props.currentProject.errors}
              onSubmit={this.createIssue.bind(this)}
              ref="form">
          <Selector name="project"
                    onChange={this.updateSelectors.bind(this)}
                    tabIndex={1}
                    value={project.id}>
            {options.selectableProjects}
          </Selector>
          <FormInput autoFocus
                     label="Title"
                     name="title"
                     tabIndex={2}
                     type="text"
                     value={project.title}/>
          <FormInput label="Description"
                     multiline={true}
                     name="description"
                     tabIndex={3}
                     value={project.description}/>

          <div className="issue-new__details">
            <Selector name="assignee"
                      placeholder={
                        <IssueField text="Unassigned"
                                    value=""/>
                      }
                      tabIndex={4}
                      value="">
              {options.assignee}
            </Selector>
            <Selector name="priority"
                      placeholder={
                        <IssueField label="Priority"
                                    text="Not selected"
                                    value=""/>
                      }
                      tabIndex={5}
                      value="">
              {options.priority}
            </Selector>
          </div>
          <div className="issue-new__actions">
            <Button color="green" tabIndex="6" type="submit">Done</Button>
          </div>
        </Form>
      </ContentMiddleLayout>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    projects: state.projects,
    currentProject: state.currentProject
  };
};

export default connect(mapStateToProps)(New);
