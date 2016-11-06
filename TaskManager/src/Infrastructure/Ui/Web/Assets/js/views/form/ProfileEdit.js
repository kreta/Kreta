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
import {connect} from 'react-redux'
import {Field, reduxForm} from 'redux-form'

import FormInput from './../component/FormInput';
import Button from './../component/Button';

const validate = (values) => {
  const errors = {},
    requiredFields = ['first_name', 'last_name', 'username'];
  requiredFields.forEach(field => {
    if (!values[field]) {
      errors[field] = 'Required'
    }
  });

  return errors;
};

@reduxForm({ form: 'ProfileEdit', validate })
@connect(state => ({
  initialValues: state.profile.profile
}))
export default class ProfileEdit extends React.Component {
  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        {/*<FormInputFile filename={user.photo ? user.photo.name : ''} name="photo" value=""/>*/}
        <Field label="First Name" name="first_name" component={FormInput} tabIndex={2}/>
        <Field label="Last Name" name="last_name" component={FormInput} tabIndex={3}/>
        <Field label="Username" name="username" component={FormInput} tabIndex={4}/>
        <div className="issue-new__actions">
          <Button color="green" type="submit">Update</Button>
        </div>
      </form>
    )
  }
}
