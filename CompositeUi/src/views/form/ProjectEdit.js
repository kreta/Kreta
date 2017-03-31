/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {connect} from 'react-redux';
import React from 'react';
import {Field, reduxForm} from 'redux-form';

import Button from './../component/Button';
import Form from './../component/Form';
import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import {Row, RowColumn} from './../component/Grid';

const validate = (values) => {
  const
    errors = {},
    requiredFields = ['name', 'short_name'];

  requiredFields.forEach(field => {
    if (!values[field]) {
      errors[field] = 'Required';
    }
  });

  return errors;
};

@connect(state => ({
  updating: state.currentOrganization.updating,
  initialValues: {
    name: state.currentProject.project.name,
    short_name: state.currentProject.project.slug
  }
}))
@reduxForm({form: 'ProjectEdit', validate})
class ProjectEdit extends React.Component {
  render() {
    const {handleSubmit, updating} = this.props;

    return (
      <Form onSubmit={handleSubmit}>
        <Row>
          <RowColumn>
            <Field autoFocus component={FormInput} label="Project Name" name="name" tabIndex={1}/>
            <Field component={FormInput} label="Short name" name="short_name" tabIndex={2}/>
            <FormActions>
              <Button color="green" disabled={updating} tabIndex={3} type="submit">Update</Button>
            </FormActions>
          </RowColumn>
        </Row>
      </Form>
    );
  }
}

export default ProjectEdit;
