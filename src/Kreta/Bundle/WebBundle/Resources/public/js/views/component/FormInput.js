/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../scss/components/_form.scss';

import React from 'react';
import classnames from 'classnames';

export default React.createClass({
  propTypes: {
    error: React.PropTypes.bool,
    success: React.PropTypes.bool,
    multiline: React.PropTypes.bool
  },
  componentWillMount() {
    this.setState({
      value: this.props.value ? this.props.value : ''
    })
  },
  onChange(event) {
    this.setState({value: event.target.value});
  },
  getInputField() {
    let {label, value, ...props} = this.props;
    const inputClasses = classnames('form-input__input', {
      'form-input__input--filled': this.state.value.length > 0
    });

    if (this.props.multiline) {
      return (
        <textarea className={inputClasses}
                  onChange={this.onChange}
                  ref="input"
                  value={this.state.value}
          {...props}>
        </textarea>
      );
    }
    else {
      return (
        <input className={inputClasses}
               onChange={this.onChange}
               ref="input"
               value={this.state.value}
          {...props}/>
      );
    }
  },
  render() {
    let {label, ...props} = this.props;

    const rootClasses = classnames('form-input', {
      'form-input--error': this.props.error,
      'form-input--success': this.props.success
    });

    return (
      <div className={rootClasses} onClick={this.focus}>
        {this.getInputField()}
        <label className="form-input__label">{label}</label>
        <div className="form-input__bar"></div>
      </div>
    );
  },
  blur () {
    this.refs.input.blur();
  },
  focus () {
    this.refs.input.focus();
  }
});
