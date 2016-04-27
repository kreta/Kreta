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

  getOrganizationInput() {
    if(!this.props.organization.organization) {
      return;
    }

    return (
      <input type='hidden' name='organization' value={this.props.organization.organization.id}/>
     );
  }

  render() {
    return (
      <ContentMiddleLayout centered>
        <Form errors={this.props.projects.errors}
              onSubmit={this.createProject.bind(this)}
              ref="form">
          <FormInputFile name="image"
                         value=""/>
          <FormInput label="Project name"
                     name="name"
                     tabIndex="1"
                     type="text"/>
          {this.getOrganizationInput()}
          <div className="issue-new__actions">
            <Button color="green"
                    tabIndex="2"
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
    projects: state.projects,
    organization: state.currentOrganization
  };
};

export default connect(mapStateToProps)(New);
