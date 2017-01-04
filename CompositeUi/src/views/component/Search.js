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
import {Link} from 'react-router';
import {Field, reduxForm} from 'redux-form';

import FormInput from './FormInput';

@connect()
@reduxForm({form: 'Search'})
class Search extends React.Component {
  static propTypes = {
    onChange: React.PropTypes.func,
  };

  render() {
    const {onChange} = this.props;

    return (
      <Link to="/search">
        <form autoComplete="off">
          <Field autoFocus component={FormInput} label="Search..." name="search" props={{onChange}} tabIndex={1}/>
        </form>
      </Link>
    );
  }
}

export default Search;
