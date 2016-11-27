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
import FormInput from './../component/FormInput';
import FormInputFile from './../component/FormInputFile';

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

@connect(state => ({initialValues: state.currentProject.project}))
@reduxForm({form: 'ProjectEdit', validate})
export default class ProjectEdit extends React.Component {
  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        <div className="section-header">
          <div className="section-header-title"></div>
          <div>
            <Button color="green"
                    tabIndex="3"
                    type="submit">
              Done
            </Button>
          </div>
        </div>
        <Field component="hidden" name="id"/>
        <FormInputFile filename={''}
                       name="image"
                       value=""/>
        <Field component={FormInput} label="Project Name" name="name" tabIndex={2}/>
      </form>
    );
  }
}
