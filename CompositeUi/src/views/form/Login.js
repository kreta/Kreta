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
    requiredFields = ['username', 'password'];

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
      <form onSubmit={handleSubmit}>
        <Row center>
          <RowColumn large={6}>
            <Field autoFocus component={FormInput} label="Username" name="username" tabIndex={1}/>
            <Field component={FormInput} label="Password" name="password" tabIndex={2} type="password"/>
            <FormActions>
              <Button color="green" tabIndex={3} type="submit">Done</Button>
            </FormActions>
          </RowColumn>
        </Row>
      </form>
    );
  }
}

export default Login;
