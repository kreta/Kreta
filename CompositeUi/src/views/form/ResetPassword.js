/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/form/_form-reset-password.scss';

import React from 'react';
import {Field, reduxForm} from 'redux-form';

import Button from './../component/Button';
import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import {Row, RowColumn} from './../component/Grid';

const validate = (values) => {
  const
    errors = {},
    requiredFields = ['email'];

  if (!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(values.email)) {
    errors.email = 'Invalid email address';
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
              <p className="form-reset-password__claim">
                Enter your email address and we will send you a link to reset your password.
              </p>
            <Field autoFocus component={FormInput} label="Email" name="email" tabIndex={1}/>
            <FormActions>
              <Button color="green" size="full" tabIndex={3} type="submit">Send password reset email</Button>
            </FormActions>
          </RowColumn>
        </Row>
      </form>
    );
  }
}

export default Login;
