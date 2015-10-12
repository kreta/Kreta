/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../../scss/views/page/issue/_new.scss';

import React from 'react';
import {History} from 'react-router';
import Select from 'react-select';
import $ from 'jquery';

import {FormSerializerService} from '../../../service/FormSerializer';
import {Issue} from '../../../models/Issue';
import {NotificationService} from '../../../service/Notification';
import ContentMiddleLayout from '../../layout/ContentMiddleLayout.js';

export default React.createClass({
  getInitialState() {
    return {
      isLoading: true,
      project: null,
      selectableProjects: []
    };
  },
  mixins: [History],
  componentDidMount() {
    this.selectorsLeft = 0;
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
    const project = App.collection.project.get(projectId);
    this.selectorsLeft = 2;

    project.on('change', $.proxy(this.onProjectUpdated, this));
    this.setState({
      project,
      selectableProjects: App.collection.project,
      isLoading: true
    });
  },
  onProjectUpdated(model) {
    this.selectorsLeft--;
    this.setState({
      isLoading: this.selectorsLeft,
      project: model
    });
  },
  save(ev) {
    ev.preventDefault();

    const issue = FormSerializerService.serialize(
      $(this.refs.form), Issue
    );

    this.setState({isLoading: true});

    issue.save(null, {
      success: (model) => {
        NotificationService.showNotification({
          type: 'success',
          message: 'Issue created successfully'
        });
        this.history.pushState(null, `/project/${model.get('project')}`);
      }, error: () => {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while saving this issue'
        });
        this.setState({isLoading: false});
      }
    });
  },
  render() {
    if (!this.state.project) {
      return <div>Loading</div>;
    }
    const selectableProjects = this.state.selectableProjects.map((project) => {
        return {
          label: project.get('name'),
          value: project.id
        };
      }),
      assignee = this.state.project.get('participants').map((p) => {
        return {
          value: p.user.id,
          label: `${p.user.first_name} ${p.user.last_name}`
        };
      }),
      priority = this.state.project.get('issue_priorities').map((p) => {
        return {
          label: p.name,
          value: p.id
        };
      }),
      type = this.state.project.get('issue_types').map((t) => {
        return {
          label: t.name,
          value: t.id
        };
      });

    return (
      <ContentMiddleLayout>
        <form id="issue-new"
              method="POST"
              onSubmit={this.save}
              ref="form">
          <div className="issue-new-actions">
            <button className="button">Cancel</button>
            <button className="button green"
                    tabIndex="7"
                    type="submit">Done</button>
          </div>
          <Select data-placeholder="Select project"
                  name="project"
                  onChange={this.updateSelectors}
                  options={selectableProjects}
                  style={{width: '100%'}}
                  tabIndex="1"
                  value={this.state.project.id}/>
          <input className="big"
                 name="title"
                 placeholder="Type your task title"
                 tabIndex="2"
                 type="text"
                 value={this.state.project.title}/>
          <textarea name="description"
                    placeholder="Type your task description"
                    tabIndex="3"
                    value={this.state.project.description}></textarea>
          <div className={`issue-new__details${this.state.isLoading ? ' issue-new__details--hidden' : ''}`}>
            <Select data-placeholder="Unassigned"
                    name="assignee"
                    options={assignee}
                    style={{width: '25%'}}
                    tabIndex="4"/>
            <Select data-placeholder="No priority"
                    name="priority"
                    options={priority}
                    style={{width: '25%'}}
                    tabIndex="5"/>
            <Select data-placeholder="No priority"
                    name="type"
                    options={type}
                    style={{width: '25%'}}
                    tabIndex="6"/>
          </div>
        </form>
      </ContentMiddleLayout>
    );
  }
});

