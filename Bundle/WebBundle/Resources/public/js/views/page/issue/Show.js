/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../scss/views/page/issue/_show.scss';

import React from 'react';
import $ from 'jquery';

import {Issue} from '../../../models/Issue.js';
import UserImage from '../../component/UserImage.js';
import IssueField from '../../component/IssueField.js';
import HelpText from '../../component/HelpText.js';
import Selector from '../../component/Selector.js';
import Button from '../../component/Button.js';
import {FormSerializerService} from '../../../service/FormSerializer.js';
import {NotificationService} from '../../../service/Notification.js';

export default React.createClass({
  propTypes: {
    issue: React.PropTypes.object.isRequired,
    project: React.PropTypes.object.isRequired
  },
  getInitialState() {
    return {
      issueChanged: false,
      issue: this.props.issue
    };
  },
  componentWillReceiveProps: function(nextProps) {
    this.setState({
      issue: nextProps.issue,
      issueChanged: false
    });
  },
  selectorChanged(value, name) {
    /*this.setState({
      issue: this.state.issue.set(name, {id: value}),
      issueChanged: true
    });*/
  },
  updateInput(ev) {
    this.setState({
      issue: this.state.issue.set(ev.target.name, ev.target.value),
      issueChanged: true
    });
  },
  doTransition(id) {
    this.state.issue.doTransition(id, {
      success : (data) => {
        this.setState({issue: this.state.issue.set(data)});
      }
    });
  },
  getProjectOptions() {
    var project = App.collection.project.get(this.props.project.id);
    if(!project) {
      return {
        asignee: [],
        priority: [],
        type: []
      };
    }
    var assignee = project.get('participants').map((p) => {
      return (
        <IssueField image={<UserImage user={p.user}/>}
                    key={p.user.id}
                    label="Assigned to"
                    text={`${p.user.first_name} ${p.user.last_name}`}
                    value={p.user.id}/>
      );

    }),
    priority = project.get('issue_priorities').map((p) => {
      return (
        <IssueField image={<i className="fa fa-exclamation"></i>}
                    key={p.id}
                    label="Priority"
                    text={p.name}
                    value={p.id}/>
      );
    });

    return {assignee, priority};
  },
  save(ev) {
    ev.preventDefault();

    const issue = FormSerializerService.serialize(
      $(this.refs.form), Issue
    );

    this.setState({issueChanged: false});
    issue.save(null, {
      success: () => {
        NotificationService.showNotification({
          type: 'success',
          message: 'Issue edited successfully'
        });
      }, error: () => {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while editing this issue'
        });
      }
    });
  },
  render() {
    const issue = this.state.issue.toJSON();
    const options = this.getProjectOptions();
    let saveButton = <HelpText text="You can change issue details inline"/>;
    if(this.state.issueChanged) {
      saveButton = <Button color="green" type="submit">Done</Button>;
    }
    const allowedTransitions = this.state.issue.getAllowedTransitions().map((transition, index) => {
      return (
        <Button color="green"
                key={index}
                onClick={this.doTransition.bind(this, transition.id)}>
          {transition.name}
        </Button>
      );
    });
    return (
      <form className="issue-show"
            onSubmit={this.save}
            ref="form">
        <input name="id" type="hidden" value={issue.id}/>
        <input name="project" type="hidden" value={this.props.project.id}/>
        <input className="issue-show__title"
               name="title"
               onChange={this.updateInput}
               value={issue.title}/>
        <section className="full-issue-transitions">
          {allowedTransitions}
        </section>
        <section className="issue-show__fields">
          <Selector disabled={true}
                    name="assignee"
                    onChange={this.selectorChanged}
                    value={issue.assignee.id}>
            {options.assignee}
          </Selector>
          <Selector disabled={true}
                    name="priority"
                    onChange={this.selectorChanged}
                    value={issue.priority.id}>
            {options.priority}
          </Selector>
        </section>
        <textarea className="issue-show__description"
                  name="description"
                  onChange={this.updateInput}
                  value={issue.description}/>
        <div className="issue-show__save">
          {saveButton}
        </div>
      </form>
    );
  }
});
