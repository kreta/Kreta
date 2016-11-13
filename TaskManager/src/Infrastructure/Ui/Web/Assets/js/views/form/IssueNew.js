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
import Selector from './../component/Selector';
import Thumbnail from './../component/Thumbnail';
import SelectorOption from './../component/SelectorOption';
import {Row, RowColumn} from './../component/Grid';

const validate = (values) => {
  const errors = {},
    requiredFields = ['title', 'description', 'project', 'assignee', 'priority'];
  requiredFields.forEach(field => {
    if (!values[field] || values[field] === '') {
      errors[field] = 'Required'
    }
  });

  return errors;
};

@connect(state => (state => {
  console.log(state.currentProject.project);
  return {
    initialValues: {
      project: state.currentProject.project !== null ? state.currentProject.project.id : ''
    },
    projects: state.projects.projects
}}))
@reduxForm({form: 'IssueNew', validate})
export default class extends React.Component {
  getProjectOptions() {
    const defaultEl = [<SelectorOption value="" text="No project selected"/>],
          optionsEl = this.props.projects.map(project => {
      return(<SelectorOption value={project.id}
                      text={project.name}
                      thumbnail={<Thumbnail image={null} text={project.name}/>}/>)
    });

    return [...defaultEl,...optionsEl];
  }

  render() {
    const {handleSubmit} = this.props;

    return (
      <form onSubmit={handleSubmit}>
        <Row>
          <RowColumn>
            <Field name="project" component={Selector} tabIndex={1}>
              {this.getProjectOptions()}
            </Field>
            <Field label="Title" name="title" component={FormInput} tabIndex={2} autoFocus/>
            <Field label="Description" name="description" component={FormInput} tabIndex={3}/>
          </RowColumn>
        </Row>
        <Row collapse>
          <RowColumn large={4} medium={6}>
            <Field name="assignee" component={Selector} tabIndex={4}>
              <SelectorOption value=""
                              text="Unassigned"
                              thumbnail={<Thumbnail image={null} text=""/>}/>
              <SelectorOption value="1"
                              text="User 1"
                              thumbnail={<Thumbnail image={null} text="User 1"/>}/>
            </Field>
          </RowColumn>
          <RowColumn large={4} medium={6}>
            <Field name="priority" component={Selector} tabIndex={5}>
              <SelectorOption value="" text="Select one..."/>
              <SelectorOption value="1" text="High"/>
            </Field>
          </RowColumn>
        </Row>
        <Row>
          <Button color="green" tabIndex="6" type="submit">Done</Button>
        </Row>
      </form>
    )
  }
};
