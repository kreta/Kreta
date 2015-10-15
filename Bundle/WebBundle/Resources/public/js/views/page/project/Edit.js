/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';
import $ from 'jquery';

import {FormSerializerService} from '../../../service/FormSerializer';
import {Project} from '../../../models/Project';

export default React.createClass({
  propTypes: {
    project: React.PropTypes.object
  },
  saveProject(ev) {
    ev.preventDefault();

    var project = FormSerializerService.serialize(
      $(this.refs.settingsForm), Project
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
  render() {
    return (
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
        <input name="id" type="hidden" value={this.props.project.id}/>
        <input className="big"
        defaultValue={this.props.project.get('name')}
        name="name"
        placeholder="Type your project name"
        tabIndex="1"
        type="text"/>
        <input defaultValue={this.props.project.get('short_name')}
        name="short_name"
        placeholder="Type a short name for your project"
        tabIndex="2"
        type="text"/>
      </form>
    );
  }
});
