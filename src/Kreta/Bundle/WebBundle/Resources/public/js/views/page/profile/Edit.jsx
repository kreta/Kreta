/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {connect} from 'react-redux';
import React from 'react';
import ReactDOM from 'react-dom';

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import Form from './../../component/Form';
import FormInput from './../../component/FormInput';
import FormInputFile from './../../component/FormInputFile';
import FormSerializer from './../../../service/FormSerializer';
import ProfileActions from './../../../actions/Profile';

class Edit extends React.Component {
  _save(ev) {
    ev.preventDefault();

    const profile = FormSerializer.serialize(ReactDOM.findDOMNode(this.refs.form));
    this.props.dispatch(ProfileActions.updateProfile(profile));
  }

  render() {
    const user = this.props.profile.profile;

    return (
      <ContentMiddleLayout>
        <Form onSubmit={this._save.bind(this)} ref="form">
          <FormInputFile filename={user.photo ? user.photo.name : ''}
                         name="photo"
                         value=""/>
          <FormInput label="First Name"
                     name="firstName"
                     tabIndex={2}
                     type="text"
                     value={user.first_name}/>
          <FormInput label="Last Name"
                     name="lastName"
                     tabIndex={3}
                     type="text"
                     value={user.last_name}/>
          <FormInput label="Username"
                     name="username"
                     tabIndex={4}
                     type="text"
                     value={user.username}/>

          <div className="issue-new__actions">
            <Button color="green" type="submit">Update</Button>
          </div>
        </Form>
      </ContentMiddleLayout>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    profile: state.profile
  };
};

export default connect(mapStateToProps)(Edit);
