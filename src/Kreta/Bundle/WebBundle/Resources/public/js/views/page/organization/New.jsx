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

import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import Button from './../../component/Button';
import Form from './../../component/Form';
import FormInput from './../../component/FormInput';
import FormInputFile from './../../component/FormInputFile';
import FormSerializer from '../../../service/FormSerializer';
import OrganizationActions from './../../../actions/Organizations';

export default class Show extends React.Component {
  createOrganization(ev) {
    ev.preventDefault();
    const organization = FormSerializer.serialize(ReactDOM.findDOMNode(this.refs.form));
    this.props.dispatch(OrganizationActions.createOrganization(organization));
  }
  render() {
    return (
      <ContentMiddleLayout>
        <Form errors={this.props.errors}
              onSubmit={this.createOrganization.bind(this)}
              ref="form">
          <FormInputFile name="image"
                         value=""/>
          <FormInput label="Organization name"
                     name="name"
                     tabIndex="1"
                     type="text"
                     value=""/>
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
    errors: state.organizations.errors
  };
};

export default connect(mapStateToProps)(Show);
