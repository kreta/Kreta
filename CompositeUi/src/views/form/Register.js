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
import Form from './../component/Form';
import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import HelpText from './../component/HelpText';
import {Row, RowColumn} from './../component/Grid';

const validate = (values) => {
  const
    errors = {},
    requiredFields = ['email', 'password', 'repeated_password'];

  if (typeof values.password !== 'undefined' && values.password.length < 6) {
    errors.password = 'Password must be at least 6 characters';
  }

  if (values.password !== values.repeated_password) {
    errors.repeated_password = 'Passwords do not match';
  }

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

@connect(state => ({registering: state.user.processing}))
@reduxForm({form: 'Register', validate})
class Register extends React.Component {
  static propTypes = {
    handleSubmit: React.PropTypes.func
  };

  render() {
    const {handleSubmit, registering} = this.props;

    return (
      <Form onSubmit={handleSubmit}>
        <Row center>
          <RowColumn large={6}>
            <Field autoFocus component={FormInput} label="Email" name="email" tabIndex={1}/>
            <Field component={FormInput} label="Password" name="password" tabIndex={2} type="password"/>
            <Field component={FormInput} label="Repeat password" name="repeated_password" tabIndex={3} type="password"/>
            <FormActions expand>
              <Button color="green" disabled={registering} tabIndex={3} type="submit">Sign up for Kreta</Button>
            </FormActions>
            <HelpText center>
                By clicking "Sign up for Kreta", you agree to
                our <a href="#">terms of service</a> and <a href="#">privacy policy</a>.
                We'll occasionally send you account related emails.
            </HelpText>
          </RowColumn>
        </Row>
      </Form>
    );
  }
}

export default Register;
