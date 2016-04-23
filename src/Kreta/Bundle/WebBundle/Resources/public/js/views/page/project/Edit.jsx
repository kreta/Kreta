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
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';

import ProjectsActions from '../../../actions/Projects';
import Button from './../../component/Button';
import Form from './../../component/Form';
import FormInput from './../../component/FormInput';
import FormInputFile from './../../component/FormInputFile';
import FormSerializer from './../../../service/FormSerializer';
import SectionHeader from './../../component/SectionHeader';

class Edit extends React.Component {
  updateProject(ev) {
    ev.preventDefault();
    const project = FormSerializer.serialize(ReactDOM.findDOMNode(this.refs.form));
    this.props.dispatch(ProjectsActions.updateProject(this.props.project.id, project));
  }

  render() {
    const
      project = this.props.project,
      image = project.image;

    return (
      <Form errors={this.props.project.errors}
            onSubmit={this.updateProject.bind(this)}
            ref="form">
        <SectionHeader actions={<Button color="green" tabIndex="3" type="submit">Edit</Button>}/>
        <FormInputFile filename={image ? image.name : ''}
                       name="image"
                       value=""/>
        <FormInput label="Project name"
                   name="name"
                   tabIndex="1"
                   type="text"
                   value={project.name}/>
      </Form>
    );
  }
}

export default connect(() => {return{}})(Edit);
