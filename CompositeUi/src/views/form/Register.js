/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/form/_form-register.scss';

import React from 'react';
import {Field, reduxForm} from 'redux-form';

import Button from './../component/Button';
import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import {Row, RowColumn} from './../component/Grid';

const validate = (values) => {
  const
    errors = {},
    requiredFields = ['email', 'password'];

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

@reduxForm({form: 'Register', validate})
class Register extends React.Component {
  static propTypes = {
    handleSubmit: React.PropTypes.func
  };

  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        <Row center>
          <RowColumn large={6}>
            <Field autoFocus component={FormInput} label="Email" name="email" tabIndex={1}/>
            <Field component={FormInput} label="Password" name="password" tabIndex={2} type="password"/>
            <FormActions>
              <Button color="green" size="full" tabIndex={3} type="submit">Sign up for Kreta</Button>
            </FormActions>
            <FormActions>
              <p className="form-register__privacy">
                By clicking "Sign up for Kreta", you agree to
                our <a href="#">terms of service</a> and <a href="#">privacy policy</a>.
                We'll occasionally send you account related emails.
              </p>
            </FormActions>
          </RowColumn>
        </Row>
      </form>
    );
  }
}

export default Register;
