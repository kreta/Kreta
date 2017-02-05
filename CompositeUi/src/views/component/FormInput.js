/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_form-input.scss';

import React from 'react';
import classnames from 'classnames';

class FormInput extends React.Component {
  getInputField() {
    const {
        auxLabelEl,                 // eslint-disable-line no-unused-vars
        input,
        label,                      // eslint-disable-line no-unused-vars
        meta: {touched, error},     // eslint-disable-line no-unused-vars
        multiline,
        onChange,
        ...custom
      } = this.props,
      inputClasses = classnames(
        'form-input__input',
        {'form-input__input--filled': input.value.length > 0}
      );

    if (multiline) {
      return (
        <textarea className={inputClasses} onKeyUp={onChange} {...input} {...custom} ref="input"/>
      );
    }

    return (
      <input className={inputClasses} onKeyUp={onChange} {...input} {...custom} ref="input"/>
    );
  }

  getLabelField() {
    const {multiline, label, auxLabelEl} = this.props;

    if (multiline) {
      return (
        <label className="form-input__label form-input__label--multiline">{label}</label>
      );
    }

    return (
      <label className="form-input__label">
        {label}
        {auxLabelEl}
      </label>
    );
  }

  render() {
    const
      {input, label, meta: {touched, error}} = this.props, // eslint-disable-line no-unused-vars
      rootClasses = classnames('form-input', {
        'form-input--error': touched && error,
        'form-input--success': input.value.length > 0 && !error
      });

    return (
      <div className={rootClasses} onClick={this.focus.bind(this)}>
        {this.getInputField()}
        {this.getLabelField()}
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
