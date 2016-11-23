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

import Button from './../../component/Button';
import ProjectActions from './../../../actions/CurrentProject';
import Selector from './../../component/Selector';
import Thumbnail from './../../component/Thumbnail';

@connect(state => ({currentProject: state.currentProject}))
export default class extends React.Component {
  updateIssue(ev) {
    ev.preventDefault();
    this.props.dispatch(ProjectActions.updateIssue(issue));
  }

  getProjectOptions() {
    const project = this.props.currentProject.project;

    const assignee = project.participants.map((p) => {
        let assigneeName = `${p.user.first_name} ${p.user.last_name}`;
        if (p.user.first_name === '' || p.user.first_name === undefined) {
          assigneeName = p.user.username;
        }

        return (
          <IssueField image={<Thumbnail image={p.user.photo.name} text={`${p.user.first_name} ${p.user.last_name}`}/>}
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

  render() {
    const issue = this.props.currentProject.selectedIssue;
    let allowedTransitions = [];

    return (
      <form errors={this.props.currentProject.errors}
            method="PUT"
            ref="form"
            onSubmit={this.updateIssue.bind(this)}>
        <input name="id" type="hidden" value={issue.id}/>
        <input name="project" type="hidden" value={this.props.currentProject.project.id}/>
        <input className="issue-show__title"
               name="title"
               onChange={this.updateInput}
               value={issue.title}/>
        <section className="issue-show__transitions">
          {allowedTransitions}
        </section>
        {/*<section className="issue-show__fields">*/}
          {/*<Selector name="assignee"*/}
                    {/*value={issue.assignee.id}>*/}
            {/*{options.assignee}*/}
          {/*</Selector>*/}
          {/*<Selector name="priority"*/}
                    {/*value={issue.priority.id}>*/}
            {/*{options.priority}*/}
          {/*</Selector>*/}
        {/*</section>*/}
        <textarea className="issue-show__description"
                  name="description"
                  value={issue.description}/>

        <div className="issue-show__save">
          <Button color="green" type="submit">
            Save changes
          </Button>
        </div>
      </form>
    );
  }
}

