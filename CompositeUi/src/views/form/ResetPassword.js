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
import {Field, reduxForm} from 'redux-form';

import Button from './../component/Button';
import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import {Row, RowColumn} from './../component/Grid';

const validate = (values) => {
  const
    errors = {},
    requiredFields = ['password', 'repeated_password'];

  if (typeof values.password !== 'undefined' && values.password.length < 6) {
    errors.password = 'Password must be at least 6 characters';
  }

  if (values.password !== values.repeated_password) {
    errors.repeated_password = 'Passwords do not match';
  }

  requiredFields.forEach(field => {
    if (!values[field] || values[field] === '') {
      errors[field] = 'Required';
    }
  });

  return errors;
};

@reduxForm({form: 'ResetPassword', validate})
class Login extends React.Component {
  static propTypes = {
    handleSubmit: React.PropTypes.func
  };

  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        <Row center>
          <RowColumn large={6}>
            <Field component={FormInput} label="Password" name="password" tabIndex={1} type="password"/>
            <Field component={FormInput} label="Repeat password" name="repeated_password" tabIndex={2} type="password"/>
            <FormActions>
              <Button color="green" size="full" tabIndex={3} type="submit">Change password</Button>
            </FormActions>
          </RowColumn>
        </Row>
      </form>
    );
  }
}

export default Login;
