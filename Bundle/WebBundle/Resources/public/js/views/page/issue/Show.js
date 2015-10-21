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
import $ from 'jQuery';

import {Issue} from '../../../models/Issue.js';
import UserImage from '../../component/UserImage.js';
import IssueField from '../../component/IssueField.js';
import HelpText from '../../component/HelpText.js';
import Selector from '../../component/Selector.js';
import {FormSerializerService} from '../../../service/FormSerializer.js';
import {NotificationService} from '../../../service/Notification.js';

export default React.createClass({
  propTypes: {
    issue: React.PropTypes.object.isRequired,
    project: React.PropTypes.object.isRequired
  },
  getInitialState() {
    return {
      issueChanged: false
    };
  },
  issueChanged() {
    this.setState({issueChanged: true});
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
                    label="Assigned to"
                    text={`${p.user.first_name} ${p.user.last_name}`}
                    value={p.user.id}/>
      );

    }),
    priority = project.get('issue_priorities').map((p) => {
      return (
        <IssueField image={<i className="fa fa-exclamation"></i>}
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
    const issue = this.props.issue.toJSON();
    const options = this.getProjectOptions();
    let saveButton = <HelpText text="You can change issue details inline"/>;
    if(this.state.issueChanged) {
      saveButton = <button className="button green" type="submit">Save changes</button>;
    }
    return (
      <form className="issue-show"
            onSubmit={this.save}
            ref="form">
        <input name="id" type="hidden" value={issue.id}/>
        <input name="project" type="hidden" value={this.props.project.id}/>
        <input className="issue-show__title"
               defaultValue={issue.title}
               name="title"/>
        <section className="full-issue-transitions">

        </section>
        <section className="issue-show__fields">
          <Selector name="assignee"
                    onChange={this.issueChanged}
                    value={issue.assignee.id}>
            {options.assignee}
          </Selector>
          <Selector name="priority"
                    onChange={this.issueChanged}
                    value={issue.priority.id}>
            {options.priority}
          </Selector>
        </section>
        <textarea className="issue-show__description"
                  name="description"
                  onKeyUp={this.issueChanged}
                  defaultValue={issue.description}/>
        <div className="issue-show__save">
          {saveButton}
        </div>
      </form>
    );
  }
});
