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

import React from 'react';

import Button from '../../component/Button';
import Form from '../../component/Form';
import HelpText from '../../component/HelpText';
import Icon from '../../component/Icon';
import IssueField from '../../component/IssueField';
import Selector from '../../component/Selector';
import UserImage from '../../component/UserImage';

export default React.createClass({
  propTypes: {
    issue: React.PropTypes.object.isRequired,
    project: React.PropTypes.object.isRequired
  },
  doTransition(id) {
    // Trigger doTransitionAction
  },
  getProjectOptions() {
    const project = this.props.project;

    const assignee = project.participants.map((p) => {
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
  },
  render() {
    const issue = this.props.issue,
      options = this.getProjectOptions();
    let allowedTransitions = [];

    return (
      <Form onSaveSuccess={this.onIssueSaved}>
        <input name="id" type="hidden" value={issue.id}/>
        <input name="project" type="hidden" value={this.props.project.id}/>
        <input className="issue-show__title"
               name="title"
               onChange={this.updateInput}
               value={issue.title}/>
        <section className="issue-show__transitions">
          {allowedTransitions}
        </section>
        <section className="issue-show__fields">
          <Selector name="assignee"
                    value={issue.assignee.id}>
            {options.assignee}
          </Selector>
          <Selector name="priority"
                    value={issue.priority.id}>
            {options.priority}
          </Selector>
        </section>
        <textarea className="issue-show__description"
                  name="description"
                  value={issue.description}/>

        <div className="issue-show__save">
            <Button color="green" type="submit">Save changes</Button>
        </div>
      </Form>
    );
  }
});
