/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';

import {SelectorView} from '../../component/selector';
import {Issue} from '../../../models/issue';
import {NotificationService} from '../../../service/notification';
import {FormSerializerService} from '../../../service/form-serializer';

export default React.createClass({
  getInitialState() {
    return {
      project: null,
      selectableProjects: []
    };
  },
  componentDidMount() {
    this.setState({
      project: App.collection.project.get(this.props.params.projectId),
      selectableProjects: App.collection.project
    });
  },
  render() {
    if(!this.state.project) {
      return <div>Loading</div>;
    }
    let selectableProjects = this.state.selectableProjects.map((project) => {
      return (
        <option value={project.id}>
          {project.get('name')}
        </option>
      );
    });
    let assignee = this.state.project.get('participants').map((participant) => {
      return (
        <option value={participant.user.id}>
          { participant.user.first_name } { participant.user.last_name }
        </option>
      )
    });
    let priority = this.state.project.get('issue_priorities').map((priority) => {
      return <option value={priority.id}>{priority.name}</option>
    });
    let type = this.state.project.get('issue_types').map((type) => {
      return <option value={type.id}>{ type.name }</option>
    });
    return (
      <form id="issue-new" method="POST" action="#">
        <div className="issue-new-actions">
          <button className="button">Cancel</button>
          <button className="button green" type="submit" tabIndex="7">Done</button>
        </div>
        <select name="project" value={this.state.project.id} tabIndex="1" style={{width:'100%'}} data-placeholder="Select project">
          {selectableProjects}
        </select>
        <input type="text" className="big" name="title"
               placeholder="Type your task title"
               tabIndex="2" value={this.state.project.title}/>
        <textarea name="description" placeholder="Type your task description"
                  tabIndex="3" value={this.state.project.description}></textarea>
        <div className="issue-new-details">
          <select name="assignee" data-container-css="select2-selector--big" tabIndex="4" style={{width:'25%'}} data-placeholder="Unassigned">
            <option></option>
            {assignee}
          </select>
          <select name="priority" className="select2-selector--big" tabIndex="5" style={{width:'25%'}} data-placeholder="No priority">
            <option></option>
            {priority}
          </select>
          <select name="type" className="select2-selector--big" tabIndex="6" style={{width:'25%'}} data-placeholder="No type">
            <option></option>
            {type}
          </select>
        </div>
      </form>
    )
  }
});

