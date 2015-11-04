/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../../scss/views/page/project/_new.scss';

import React from 'react';
import {History} from 'react-router';

import {Project} from '../../../models/Project';
import Button from '../../component/Button.js';
import ContentMiddleLayout from '../../layout/ContentMiddleLayout.js';
import Form from '../../component/Form.js';
import FormInput from '../../component/FormInput.js';

export default React.createClass({
  mixins: [History],
  goToCreatedProject(model) {
    App.collection.project.add(model);
    this.history.pushState(null, `/project/${model.id}`);
  },
  showErrors(errors) {
    console.log(errors);
  },
  render() {
    return (
      <ContentMiddleLayout>
        <Form model={Project}
              onSaveError={this.showErrors}
              onSaveSuccess={this.goToCreatedProject}>
          <FormInput label="Project name"
                     name="name"
                     tabIndex="1"
                     type="text"/>
          <FormInput label="Short name"
                     maxLength="4"
                     name="shortName"
                     tabIndex="2"
                     type="text"/>
          <div className="issue-new__actions">
            <Button color="green"
                    tabIndex="3"
                    type="submit">
              Done
            </Button>
          </div>
        </Form>
      </ContentMiddleLayout>
    );
  }
});
