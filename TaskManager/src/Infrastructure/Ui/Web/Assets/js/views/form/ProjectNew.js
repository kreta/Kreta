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
    requiredFields = ['name', 'short_name'];
  requiredFields.forEach(field => {
    if (!values[field]) {
      errors[field] = 'Required'
    }
  });

  return errors;
};

@connect()
@reduxForm({form: 'ProjectNew', validate})
export default class extends React.Component {
  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        {/*<FormInputFile name="image" value=""/>*/}
        <Field label="Project Name" name="name" component={FormInput} tabIndex={2}/>
        <Field label="Short name" name="short_name" component={FormInput} tabIndex={3}/>
        <div className="issue-new__actions">
          <Button color="green" type="submit">Update</Button>
        </div>
      </form>
    )
  }
};
