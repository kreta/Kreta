/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_form-input-wysiwyg.scss';

import React from 'react';
import ReactDOM from 'react-dom';
import classnames from 'classnames';

import Wysiwyg from './../component/Wysiwyg';

class FormInputWysiwyg extends React.Component {
  constructor(props) {
    super(props);

    this.handleBlur = this.handleBlur.bind(this);
    this.handleChange = this.handleChange.bind(this);
    this.handleFocus = this.handleFocus.bind(this);
  }

  input() {
    return ReactDOM.findDOMNode(this.refs.input);
  }

  handleBlur() {
    this.input().classList.remove('form-input-wysiwyg__input--focus');
  }

  addCssClasses() {
    this.input().classList.add('form-input-wysiwyg__input--filled');
    this.input().classList.add('form-input-wysiwyg__input--success');
  }

  removeCssClasses() {
    this.input().classList.remove('form-input-wysiwyg__input--filled');
    this.input().classList.remove('form-input-wysiwyg__input--success');
  }

  handleChange(content, isEditorEmpty) {
    this.props.input.onChange(content);

    return isEditorEmpty ? this.addCssClasses() : this.removeCssClasses();
  }

  handleFocus() {
    this.input().classList.add('form-input-wysiwyg__input--focus');
  }

  renderInput() {
    const {
        input,
        label, // eslint-disable-line no-unused-vars
        meta: {touched, error}, // eslint-disable-line no-unused-vars
        ...custom
      } = this.props,
      inputClasses = classnames(
        'form-input-wysiwyg__input',
        {'form-input-wysiwyg__input--filled': input.value.length > 0}
      );

    return (
      <div className={inputClasses} ref="input">
        <input {...input} type="hidden"/>
        <Wysiwyg
          defaultValue={input.value}
          editorOnBlur={this.handleBlur}
          editorOnChange={this.handleChange}
          editorOnFocus={this.handleFocus}
          tabIndex={custom.tabIndex}
        />
      </div>
    );
  }

  render() {
    const {label} = this.props;

    return (
      <div className="form-input-wysiwyg">
        {this.renderInput()}
        <label className="form-input-wysiwyg__label">
          {label}
        </label>
        <div className="form-input-wysiwyg__bar"/>
      </div>
    );
  }
}

export default FormInputWysiwyg;
