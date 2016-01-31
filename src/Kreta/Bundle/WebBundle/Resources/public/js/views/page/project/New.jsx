/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../scss/views/page/project/_new';

import {connect} from 'react-redux';
import React from 'react';
import ReactDOM from 'react-dom';

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import Form from './../../component/Form';
import FormInput from './../../component/FormInput';
import FormInputFile from './../../component/FormInputFile';
import FormSerializer from './../../../service/FormSerializer';
import ProjectsActions from './../../../actions/Projects';

class New extends React.Component {
  createProject(ev) {
    ev.preventDefault();
    const project = FormSerializer.serialize(ReactDOM.findDOMNode(this.refs.form));
    this.props.dispatch(ProjectsActions.createProject(project));
  }

  render() {
    return (
      <ContentMiddleLayout>
        <Form errors={this.props.projects.errors}
              onSubmit={this.createProject.bind(this)}
              ref="form">
          <FormInputFile name="image"
                         value=""/>
          <FormInput label="Project name"
                     name="name"
                     tabIndex="1"
                     type="text"/>
          <FormInput label="Short name"
                     maxLength="4"
                     name="shortName"
                     tabIndex="2"
                     type="text"/>

          <div className="issue-new__actions">
            <Button color="green"
                    tabIndex="3"
                    type="submit">
              Done
            </Button>
          </div>
        </Form>
      </ContentMiddleLayout>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    projects: state.projects
  };
};

export default connect(mapStateToProps)(New);
