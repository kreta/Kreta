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

import Form from './../component/Form';
import FormActions from './../component/FormActions';
import FormInput from './../component/FormInput';
import FormInputWysiwyg from './../component/FormInputWysiwyg';
import Button from './../component/Button';
import PageHeader from './../component/PageHeader';
import {Row, RowColumn} from './../component/Grid';
import Selector from './../component/Selector';
import SelectorOption from './../component/SelectorOption';
import Thumbnail from './../component/Thumbnail';
import UserThumbnail from './../component/UserThumbnail';

const validate = (values) => {
  const
    errors = {},
    requiredFields = ['title', 'project', 'assignee', 'priority'];

  requiredFields.forEach(field => {
    if (!values[field] || values[field] === '') {
      errors[field] = 'Required';
    }
  });

  return errors;
};

@connect(state => ({
  initialValues: {
    project: state.currentProject.project.id
  },
  project: state.currentProject.project
}))

@reduxForm({form: 'TaskNew', validate})
class TaskNew extends React.Component {
  assigneeSelector() {
    const options = [(
        <SelectorOption
          key={0}
          text="Unassigned"
          thumbnail={<Thumbnail image={null} text=""/>}
          value=""
        />)],
      users = this.props.project.organization.organization_members.concat(
        this.props.project.organization.owners
      );

    users.forEach((member) => {
      options.push(
        <SelectorOption
          key={member.id}
          text={member.user_name}
          thumbnail={<UserThumbnail user={member}/>}
          value={member.id}
        />
      );
    });

    return options;
  }

  render() {
    const {project, handleSubmit} = this.props;

    return (
      <Form onSubmit={handleSubmit}>
        <Row collapse>
          <RowColumn>
            <PageHeader
              thumbnail={
                <Thumbnail
                  image={null}
                  text={project.name}
                />
              }
              title={project.name}/>
          </RowColumn>
          <RowColumn>
            <Field autoFocus component={FormInput} label="Title" name="title" tabIndex={1}/>
            <div className="task-new__description">
              <Field component={FormInputWysiwyg} label="Description" name="description" tabIndex={2}/>
            </div>
          </RowColumn>
          <RowColumn large={4} medium={6}>
            <Field component={Selector} name="assignee" tabIndex={3}>
              {this.assigneeSelector()}
            </Field>
          </RowColumn>
          <RowColumn large={4} medium={6}>
            <Field component={Selector} name="priority" tabIndex={4}>
              <SelectorOption text="Select priority..." value=""/>
              <SelectorOption text="High" value="HIGH"/>
              <SelectorOption text="Medium" value="MEDIUM"/>
              <SelectorOption text="Low" value="LOW"/>
            </Field>
          </RowColumn>
          <RowColumn>
            <FormActions>
              <Button color="green" tabIndex={5} type="submit">Done</Button>
            </FormActions>
          </RowColumn>
        </Row>
      </Form>
    );
  }
}

export default TaskNew;
