/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_form.scss';

import React from 'react';
import classnames from 'classnames';

class FormInput extends React.Component {
  getInputField() {
    const
      {input, ...custom} = this.props,
      inputClasses = classnames('form-input__input', {
        'form-input__input--filled': input.value.length > 0
      });

    if (this.props.multiline) {
      return (
        <textarea className={inputClasses} {...input} {...custom} ref="input"/>
      );
    }

    return (
      <input className={inputClasses} {...input} {...custom} ref="input"/>
    );
  }

  render() {
    const
      {input, label, meta: {touched, error}} = this.props,
      rootClasses = classnames('form-input', {
        'form-input--error': touched && error,
        'form-input--success': input.value.length > 0 && !error
      });

    return (
      <div className={rootClasses} onClick={this.focus.bind(this)}>
        {this.getInputField()}
        <label className="form-input__label">{label}</label>

        <div className="form-input__bar"></div>
      </div>
    );
  }

  blur() {
    this.refs.input.blur();
  }

  focus() {
    this.refs.input.focus();
  }
}

export default FormInput;
