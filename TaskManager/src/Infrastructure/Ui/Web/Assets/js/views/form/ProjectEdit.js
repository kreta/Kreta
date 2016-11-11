import React from 'react';
import {connect} from 'react-redux'
import {Field, reduxForm} from 'redux-form';

import Button from './../component/Button';
import FormInput from './../component/FormInput';
import FormInputFile from './../component/FormInputFile';

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

@connect(state => ({initialValues: state.currentProject.project}))
@reduxForm({form: 'ProjectEdit', validate})
export default class ProjectEdit extends React.Component {
  render(){
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
        <Field name="id" component='hidden'/>
        <FormInputFile filename={''}
                       name="image"
                       value=""/>
        <Field label="Project Name" name="name" component={FormInput} tabIndex={2}/>
      </form>
    )
  };
}
