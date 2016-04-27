/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../scss/views/page/issue/_show';
import PriorityIcon from './../../../../svg/priority';

import {connect} from 'react-redux';
import React from 'react';
import ReactDOM from 'react-dom';

import Button from './../../component/Button';
import Form from './../../component/Form';
import FormInput from './../../component/FormInput';
import FormSerializer from './../../../service/FormSerializer';
import Icon from './../../component/Icon';
import IssueField from './../../component/IssueField';
import ProjectActions from './../../../actions/CurrentProject';
import Selector from './../../component/Selector';
import TextArea from './../../component/Textarea';
import UserImage from './../../component/UserImage';

class Show extends React.Component {
  updateIssue(ev) {
    ev.preventDefault();

    const issueData = FormSerializer.serialize(ReactDOM.findDOMNode(this.refs.form));
    this.props.dispatch(ProjectActions.updateIssue(issueData, this.props.currentProject.selectedIssue.id));
  }

  doTransition(id) {
    this.props.dispatch(ProjectActions.transitionIssue(id, this.props.currentProject.selectedIssue.id));
  }

  getProjectOptions() {
    const
      project = this.props.currentProject.project,
      participants = project.participants.concat(project.organization.participants),
      assignee = participants.map((p) => {
        let assigneeName = `${p.user.first_name} ${p.user.last_name}`;
        if (p.user.first_name === '' || p.user.first_name === undefined) {
          assigneeName = p.user.username;
        }

        return (
          <IssueField image={<UserImage user={p.user}/>}
                      key={p.user.id}
                      label="Assigned to"
                      text={assigneeName}
                      value={p.user.id}/>
        );
      }),
      priority = project.issue_priorities.map((p) => {
        return (
          <IssueField image={
                        <Icon glyph={PriorityIcon}
                              style={{width: '20px', fill: p.color}}/>
                      }
                      key={p.id}
                      label="Priority"
                      text={p.name}
                      value={p.id}/>
        );
      });

    return {assignee, priority};
  }

  hasEditGrant() {
    return this.props.currentProject.selectedIssue.assignee.id === this.props.profile.profile.id;
  }

  submitButton() {
    if (false === this.hasEditGrant()) {
      return;
    }

    return (
      <div className="issue-show__save">
        <Button color="green" type="submit">
          Save changes
        </Button>
      </div>
    );
  }

  render() {
    const
      issue = this.props.issue,
      options = this.getProjectOptions(),
      fieldState = this.hasEditGrant() ? false : true,
      allowedTransitions = this.props.currentProject.project.workflow.status_transitions.filter((transition) => {
        return transition.initial_states.filter((state) => {
            return state.id === issue.status.id;
          }).length > 0;
      }).map((transition) => {
        return (
          <Button color="green"
                  key={transition.id}
                  disabled={fieldState}
                  onClick={this.doTransition.bind(this, transition.id)}>
            {transition.name}
          </Button>
        );
      });

    return (
      <Form errors={this.props.currentProject.errors}
            method="PUT"
            onSubmit={this.updateIssue.bind(this)}
            ref="form">
        <input name="project" type="hidden" value={this.props.currentProject.project.id}/>
        <FormInput className="issue-show__title"
                   disabled={fieldState}
                   name="title"
                   value={issue.title}/>
        <section className="issue-show__transitions">
          {allowedTransitions}
        </section>
        <section className="issue-show__fields">
          <Selector disabled={fieldState}
                    name="assignee"
                    value={issue.assignee.id}>
            {options.assignee}
          </Selector>
          <Selector disabled={fieldState}
                    name="priority"
                    value={issue.priority.id}>
            {options.priority}
          </Selector>
        </section>
        <TextArea className="issue-show__description"
                  id="description"
                  readOnly={fieldState}
                  value={issue.description}/>
        {this.submitButton()}
      </Form>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    currentProject: state.currentProject,
    profile: state.profile
  };
};

export default connect(mapStateToProps)(Show);
