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
import {shallow} from 'enzyme';

import FormInput from './../FormInput';

describe('<FormInput/>', () => {
  it('renders simple input', () => {
    const wrapper = shallow(
      <FormInput
        input={{value: 'example value'}}
        label="example"
        meta={{touched: false, error: false}}
      />,
    );
    expect(
      wrapper.containsMatchingElement(<input value="example value" />),
    ).toBe(true);
    expect(wrapper.containsMatchingElement(<label>example</label>)).toBe(true);
    expect(wrapper.containsMatchingElement(<textarea />)).toBe(false);
  });

  it('renders a textarea when multiline prop is used', () => {
    const wrapper = shallow(
      <FormInput
        input={{value: ''}}
        label="example"
        meta={{touched: false, error: false}}
        multiline
      />,
    );
    expect(wrapper.containsMatchingElement(<textarea />)).toBe(true);
    expect(wrapper.containsMatchingElement(<input />)).toBe(false);
  });

  it('notifies an error when the input is touched and it has an error', () => {
    const wrapper = shallow(
      <FormInput
        input={{value: ''}}
        label="example"
        meta={{touched: true, error: true}}
      />,
    );
    expect(wrapper.find('.form-input').hasClass('form-input--error')).toBe(
      true,
    );
  });

  it('notifies a value is valid when the value has at least 1 char and has no errors', () => {
    const wrapper = shallow(
      <FormInput
        input={{value: 'Valid'}}
        label="example"
        meta={{touched: true, error: false}}
      />,
    );
    expect(wrapper.find('.form-input').hasClass('form-input--success')).toBe(
      true,
    );
  });

  it('moves the label to the top when an input is filled', () => {
    const wrapper = shallow(
      <FormInput
        input={{value: 'Valid'}}
        label="example"
        meta={{touched: true, error: false}}
      />,
    );
    expect(
      wrapper.find('.form-input__input').hasClass('form-input__input--filled'),
    ).toBe(true);
  });
});
