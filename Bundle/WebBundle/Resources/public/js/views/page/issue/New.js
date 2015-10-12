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
import Select from 'react-select';

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
  componentDidMount() {
    this.selectorsLeft = 0;
    this.updateSelectors(this.props.params.projectId);
  },
  updateSelectors(projectId) {
    const project = App.collection.project.get(projectId);
    this.selectorsLeft = 3;

    project.on('change', $.proxy(this.onProjectUpdated, this));
    this.setState({
      project,
      selectableProjects: App.collection.project
    });
  },
  onProjectUpdated(model) {
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
    var project = this.state.project.get('project');

    this.setState({isLoading: true});

    issue.save(null, {
      success: (model) => {
        NotificationService.showNotification({
          type: 'success',
          message: 'Issue created successfully'
        });
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
      assignee = this.state.project.get('participants').map((participant) => {
        return {
          value: participant.user.id,
          label: `${participant.user.first_name} ${participant.user.last_name}`
        };
      }),
      priority = this.state.project.get('issue_priorities').map((priority) => {
        return {
          label: priority.name,
          value: priority.id
        };
      }),
      type = this.state.project.get('issue_types').map((type) => {
        return {
          label: type.name,
          value: type.id
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
          <div className={`issue-new-details${this.state.isLoading ? ' issue-new__details--hidden' : ''}`}>
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

