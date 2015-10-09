/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../../scss/views/page/project/_new.scss';

import React from 'react';

import {Project} from '../../../models/Project';
import {FormSerializerService} from '../../../service/FormSerializer';

export default React.createClass({
  save(ev) {
    ev.preventDefault();

    const project = FormSerializerService.serialize(
      $(this.refs.form), Project
    );

    project.save(null, {
      success: () => {
        console.log('Project new OK');
      }, error: () => {
        console.log('Project new KO');
      }
    });
  },
  render() {
    return (
      <div>
        <form ref="form">
          <div className="issue-new-actions">
            <button className="button">Cancel</button>
            <button className="button green"
                    tabIndex="3"
                    type="submit">
              Done
            </button>
          </div>
          <input className="big"
                 name="name"
                 placeholder="Type your project name"
                 tabIndex="1"
                 type="text"/>
          <input name="shortName"
                 placeholder="Type a short name for your project"
                 tabIndex="2"
                 type="text"/>
        </form>
      </div>
    );
  }
});
