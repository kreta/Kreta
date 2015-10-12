/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../../scss/views/page/project/_settings.scss';

import React from 'react';

import {Project} from '../../../models/Project';
import UserPreview from '../../component/UserPreview';
import {FormSerializerService} from '../../../service/FormSerializer';
import ContentMiddleLayout from '../../layout/ContentMiddleLayout.js';

export default React.createClass({
  getInitialState() {
    return {
      project: null
    };
  },
  componentDidMount() {
    this.setState({
      project: App.collection.project.get(this.props.params.projectId)
    });
  },
  saveProject(ev) {
    ev.preventDefault();

    var project = FormSerializerService.serialize(
      $(this.refs.settingsForm.getDOMNode()), Project
    );

    project.save(null, {
      success: () => {
        console.log('Project settings Ok');
      },
      error: () => {
        console.log('Project settings Ko');
      }
    });
  },
  addUser() {
  },
  render() {
    if (!this.state.project) {
      return <div>Loading...</div>;
    }

    const participants = this.state.project.get('participants').map((participant, index) => {
      return <UserPreview key={index} user={participant}/>;
    });
    return (
      <ContentMiddleLayout>
        <form className="spacer-top-4"
              onSubmit={this.saveProject}
              ref="settingsForm">
          <div className="section-header">
            <div className="section-header-title"></div>
            <div>
              <button className="button">Cancel</button>
              <button className="button green"
                      tabIndex="3"
                      type="submit">
                Done
              </button>
            </div>
          </div>
          <input name="id" type="hidden" value={this.state.project.id}/>
          <input className="big"
                 defaultValue={this.state.project.get('name')}
                 name="name"
                 placeholder="Type your project name"
                 tabIndex="1"
                 type="text"/>
          <input defaultValue={this.state.project.get('short_name')}
                 name="short_name"
                 placeholder="Type a short name for your project"
                 tabIndex="2"
                 type="text"/>
        </form>
        <section className="spacer-vertical-1">
          <div className="section-header">
            <h3 className="section-header-title">
              <strong>People</strong> in this project
            </h3>
            <div className="section-header-actions">
              <a className="button" href="#" onClick={this.addPeople}>
                Add people
              </a>
            </div>
          </div>
          {participants}
          <div>
          </div>
        </section>
      </ContentMiddleLayout>
    );
  }
});
