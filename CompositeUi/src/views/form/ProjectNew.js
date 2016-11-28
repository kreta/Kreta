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

import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import Button from './../component/Button';
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

@connect()
@reduxForm({form: 'ProjectNew', validate})
class ProjectNew extends React.Component {
  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        <Row>
          <RowColumn>
            {/* <FormInputFile name="image" value=""/> */}
            <Field autoFocus component={FormInput} label="Project Name" name="name" tabIndex={2}/>
            <Field component={FormInput} label="Short name" name="short_name" tabIndex={3}/>
            <FormActions>
              <Button color="green" type="submit">Update</Button>
            </FormActions>
          </RowColumn>
        </Row>
      </form>
    );
  }
}

export default ProjectNew;
