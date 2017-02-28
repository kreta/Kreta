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

import FormInput from './FormInput';

@connect()
@reduxForm({form: 'Search'})
class SearchMember extends React.Component {
  static propTypes = {
    onChange: React.PropTypes.func,
    query: React.PropTypes.string
  };

  componentDidMount() {
    this.handleInitialize();
  }

  handleInitialize() {
    this.props.initialize({
      'search': this.props.query
    });
  }

  render() {
    const {onChange} = this.props;

    return (
        <form autoComplete="off">
          <Field
            autoFocus
            component={FormInput}
            label="Search..."
            name="search"
            props={{onChange}}
            tabIndex={1}
          />
        </form>
    );
  }
}

export default SearchMember;
