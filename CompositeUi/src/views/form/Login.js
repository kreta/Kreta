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
import {Link} from 'react-router';

import Button from './../component/Button';
import FormActions from './../component/FormActions';
import Form from './../component/Form';
import FormInput from './../component/FormInput';
import HelpText from './../component/HelpText';
import {Row, RowColumn} from './../component/Grid';
import {routes} from './../../Routes';

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

@reduxForm({form: 'Login', validate})
class Login extends React.Component {
  static propTypes = {
    handleSubmit: React.PropTypes.func
  };

  render() {
    const {handleSubmit} = this.props;

    return (
      <Form onSubmit={handleSubmit}>
        <Row center>
          <RowColumn large={6}>
            <Field autoFocus component={FormInput} label="Email" name="email" tabIndex={1}/>
            <Field
              {...{
                auxLabelEl: (
                  <Link to={routes.requestResetPassword}>
                    Forgot your password?
                  </Link>
                )
              }}
              component={FormInput}
              label="Password"
              name="password"
              tabIndex={2}
              type="password"
            />
            <FormActions expand>
              <Button color="green" tabIndex={3} type="submit">Sign in Kreta</Button>
            </FormActions>
            <HelpText center>
              New to Kreta? <Link to={routes.register}>Create an account.</Link>
            </HelpText>
          </RowColumn>
        </Row>
      </Form>
    );
  }
}

export default Login;
