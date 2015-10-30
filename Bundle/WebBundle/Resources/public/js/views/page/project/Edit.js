/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';
import $ from 'jquery';

import {FormSerializerService} from '../../../service/FormSerializer';
import {Project} from '../../../models/Project';
import Button from '../../component/Button.js';

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
            <Button color="green"
                    tabIndex="3"
                    type="submit">
              Done
            </Button>
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
