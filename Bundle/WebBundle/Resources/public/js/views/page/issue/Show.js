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

import UserImage from '../../component/UserImage.js';
import IssueField from '../../component/IssueField.js';
import HelpText from '../../component/HelpText.js';

export default React.createClass({
  propTypes: {
    issue: React.PropTypes.object
  },
  getInitialState() {
    return {
      issueChanged: false
    };
  },
  componentDidUpdate () {
    this.setState({issueChanged: false});
  },
  issueChanged() {
    if(!this.state.issueChanged) {
      this.setState({issueChanged: true})
    }
  },
  getProjectOptions() {
    var project = App.collection.project.get(this.props.issue.get('project').id);
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
        <IssueField halfColumn={true}
                    image={<i className="fa fa-exclamation"></i>}
                    label="Priority"
                    text={p.name}
                    value={p.id}/>
      );
    }),
    type = project.get('issue_types').map((t) => {
      return (
        <IssueField halfColumn={true}
                    image={<i className="fa fa-coffee"></i>}
                    label="Type"
                    text={t.name}
                    value={t.id}/>
      );
    });

    return {assignee, priority, type};
  },
  render() {
    const issue = this.props.issue.toJSON();
    let saveButton = <HelpText text="You can change issue details inline"/>;
    if(this.state.issueChanged) {
      saveButton = <button className="button green">Save changes</button>;
    }
    const options = this.getProjectOptions();
    return (
      <div className="issue-show">
        <h2 className="issue-show__title">
          {issue.title}
        </h2>
        <section className="full-issue-transitions">

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
          <Selector name="priority"
                    value={issue.type.id}>
            {options.type}
          </Selector>
        </section>
        <p className="issue-show__description">
          {issue.description}
        </p>
        <div className="issue-show__save">
          {saveButton}
        </div>
      </div>
    );
  }
});
