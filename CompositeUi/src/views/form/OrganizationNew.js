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
import Button from './../component/Button';
import {Row, RowColumn} from './../component/Grid';

const validate = values => {
  const errors = {},
    requiredFields = ['name'];

  requiredFields.forEach(field => {
    if (!values[field]) {
      errors[field] = 'Required';
    }
  });

  return errors;
};

@connect(state => ({fetching: state.organization.fetching}))
@reduxForm({form: 'OrganizationNew', validate})
class OrganizationNew extends React.Component {
  static propTypes = {
    handleSubmit: React.PropTypes.func,
  };

  render() {
    const {handleSubmit, fetching} = this.props;

    return (
      <Form onSubmit={handleSubmit}>
        <Row>
          <RowColumn>
            <Field
              autoFocus
              component={FormInput}
              label="Organization Name"
              name="name"
              tabIndex={1}
            />
            <FormActions>
              <Button
                color="green"
                disabled={fetching}
                tabIndex={2}
                type="submit"
              >
                Create
              </Button>
            </FormActions>
          </RowColumn>
        </Row>
      </Form>
    );
  }
}

export default OrganizationNew;
