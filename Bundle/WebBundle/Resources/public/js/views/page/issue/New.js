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
import {Issue} from '../../../models/Issue';
import {NotificationService} from '../../../service/Notification';
import {FormSerializerService} from '../../../service/FormSerializer';

export default React.createClass({
  getInitialState() {
    return {
      project: null,
      selectableProjects: [],
      isLoading: true
    };
  },
  componentDidMount() {
    this.selectorsLeft = 0;
    this.updateSelectors(this.props.params.projectId);
  },
  updateSelectors(projectId) {
    this.selectorsLeft = 3;
    let project = App.collection.project.get(projectId);
    project.on('change', $.proxy(this.onProjectUpdated, this));
    this.setState({
      project: project,
      selectableProjects: App.collection.project
    });
  },
  onProjectUpdated(model) {
    this.setState({
      project: model,
      isLoading: this.selectorsLeft
    });
  },
  save() {
    var project = this.state.project.get('project');

    this.setState({isLoading: true});
    let issue = FormSerializerService.serialize(
      $(React.findDOMNode(this.refs.form)), Issue
    );

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
    return false;
  },
  render() {
    if (!this.state.project) {
      return <div>Loading</div>;
    }
    let selectableProjects = this.state.selectableProjects.map((project) => {
      return {
        label: project.get('name'),
        value: project.id
      }
    });
    let assignee = this.state.project.get('participants').map((participant) => {
      return {
        value: participant.user.id,
        label: participant.user.first_name + ' ' + participant.user.last_name
      }
    });
    let priority = this.state.project.get('issue_priorities').map((priority) => {
      return {
        value: priority.id,
        label: priority.name
      }
    });
    let type = this.state.project.get('issue_types').map((type) => {
      return {
        value: type.id,
        label: type.name
      }
    });
    return (
      <form id="issue-new"
            method="POST"
            ref="form"
            onSubmit={this.save}>
        <div className="issue-new-actions">
          <button className="button">Cancel</button>
          <button className="button green" type="submit" tabIndex="7">Done</button>
        </div>
        <Select name="project"
                value={this.state.project.id}
                tabIndex="1" style={{width:'100%'}}
                data-placeholder="Select project"
                options={selectableProjects}
                onChange={this.updateSelectors}/>
        <input type="text" className="big" name="title"
               placeholder="Type your task title"
               tabIndex="2" value={this.state.project.title}/>
        <textarea name="description" placeholder="Type your task description"
                  tabIndex="3" value={this.state.project.description}></textarea>

        <div className={`issue-new-details${this.state.isLoading ? ' issue-new__details--hidden': ''}`}>
          <Select name="assignee"
                  tabIndex="4"
                  style={{width:'25%'}}
                  options={assignee}
                  data-placeholder="Unassigned"/>
          <Select name="priority"
                  tabIndex="5"
                  style={{width:'25%'}}
                  options={priority}
                  data-placeholder="No priority"/>
          <Select name="type"
                  tabIndex="6"
                  style={{width:'25%'}}
                  options={type}
                  data-placeholder="No priority"/>
        </div>
      </form>
    )
  }
});

