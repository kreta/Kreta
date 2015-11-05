/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../../scss/views/page/issue/_new.scss';

import React from 'react';
import {History} from 'react-router';

import Button from '../../component/Button.js';
import ContentMiddleLayout from '../../layout/ContentMiddleLayout.js';
import Form from '../../component/Form.js';
import FormInput from '../../component/FormInput.js';
import {Issue} from '../../../models/Issue';
import IssueField from '../../component/IssueField.js';
import Selector from '../../component/Selector.js';
import UserImage from '../../component/UserImage.js';

export default React.createClass({
  getInitialState() {
    return {
      project: null
    };
  },
  mixins: [History],
  componentDidMount() {
    this.updateSelectors(this.props.params.projectId);
  },
  componentDidUpdate (prevProps) {
    const oldId = prevProps.params.projectId,
      newId = this.props.params.projectId;
    if (newId !== oldId) {
      this.updateSelectors(this.props.params.projectId);
    }
  },
  updateSelectors(projectId) {
    this.setState({project: App.collection.project.get(projectId)});
  },
  getProjectOptions() {
    const project = App.collection.project.get(this.state.project.id);
    if (!project) {
      return {
        asignee: [],
        priority: [],
        type: []
      };
    }
    var selectableProjects = App.collection.project.map((p) => {
        return (
          <IssueField
            text={p.get('name')}
            value={p.id}/>
        );
      }),
      assignee = project.get('participants').map((p) => {
        let assignee = `${p.user.first_name} ${p.user.last_name}`;
        if ('' === p.user.first_name) {
          assignee = p.user.username;
        }

        return (
          <IssueField image={<UserImage user={p.user}/>}
                      label="Assigned to"
                      text={assignee}
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

    return {selectableProjects, assignee, priority};
  },
  goToCreatedIssue(model) {
    this.history.pushState(null, `/project/${model.get('project')}`)
  },
  render() {
    if (!this.state.project) {
      return <div>Loading</div>;
    }

    const options = this.getProjectOptions();

    return (
      <ContentMiddleLayout>
        <Form model={Issue}
              onSaveSuccess={this.goToCreatedIssue}>
          <Selector name="project"
                    onChange={this.updateSelectors}
                    tabIndex={1}
                    value={this.state.project.id}>
            {options.selectableProjects}
          </Selector>
          <FormInput name="title"
                     label="Title"
                     tabIndex={2}
                     type="text"
                     value={this.state.project.title}/>
          <FormInput multiline={true}
                     name="description"
                     label="Description"
                     tabIndex={3}
                     value={this.state.project.description}/>

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
                      tabIndex={5}
                      placeholder={
                        <IssueField label="Priority"
                                    text="Not selected"
                                    value=""/>
                      }
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
});

