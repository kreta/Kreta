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
import {connect} from 'react-redux';
import {Field, reduxForm} from 'redux-form';

import Button from './../component/Button';
import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import {Row, RowColumn} from './../component/Grid';
import Selector from './../component/Selector';
import SelectorOption from './../component/SelectorOption';
import Thumbnail from './../component/Thumbnail';
import Wysiwyg from './../component/Wysiwyg';

const validate = (values) => {
  const
    errors = {},
    requiredFields = ['title', 'description', 'assignee', 'priority'];

  requiredFields.forEach(field => {
    if (!values[field] || values[field] === '') {
      errors[field] = 'Required';
    }
  });

  return errors;
};

@connect(state => ({
  initialValues: {
    project: state.currentProject.project !== null ? state.currentProject.project.id : ''
  },
  projects: state.projects.projects
}))

@reduxForm({form: 'TaskEdit', validate})
class TaskEdit extends React.Component {
  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        <Row>
          <RowColumn>
            <Field autoFocus component={FormInput} label="Title" name="title" tabIndex={2}/>
            <Field component={Selector} name="assignee" tabIndex={3}>
              <SelectorOption
                text="Unassigned"
                thumbnail={<Thumbnail image={null} text=""/>}
                value=""
              />
              <SelectorOption
                text="User 1"
                thumbnail={<Thumbnail image={null} text="User 1"/>}
                value="1"
              />
            </Field>
            <Field component={Selector} name="priority" tabIndex={4}>
              <SelectorOption text="Select one..." value=""/>
              <SelectorOption text="High" value="1"/>
            </Field>
            <Field
              component={Wysiwyg}
              hasPlaceholder={true}
              label="Description"
              multiline
              name="description"
              tabIndex={5}
            />
          </RowColumn>
        </Row>
        <Row>
          <RowColumn>
            <FormActions>
              <Button color="green" tabIndex={6} type="submit">Save</Button>
            </FormActions>
          </RowColumn>
        </Row>
      </form>
    );
  }
}

export default TaskEdit;
