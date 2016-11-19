/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react'
import {Field, reduxForm} from 'redux-form'

import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import Button from './../component/Button';
import {Row, RowColumn} from './../component/Grid';

const validate = (values) => {
  const errors = {},
    requiredFields = ['username', 'password'];
  requiredFields.forEach(field => {
    if (!values[field] || values[field] === '') {
      errors[field] = 'Required'
    }
  });

  return errors;
};

@reduxForm({form: 'Login', validate})
export default class extends React.Component {
  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        <Row center>
          <RowColumn large={6}>
            <Field label="Username" name="username" component={FormInput} tabIndex={1} autoFocus/>
            <Field label="Password" name="password" component={FormInput} type="password" tabIndex={2}/>
            <FormActions>
              <Button color="green" tabIndex={3} type="submit">Done</Button>
            </FormActions>
          </RowColumn>
        </Row>
      </form>
    )
  }
};
