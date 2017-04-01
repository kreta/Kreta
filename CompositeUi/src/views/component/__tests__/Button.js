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
import { shallow } from 'enzyme';
import Button from '../Button';

describe('<Button />', () => {
  it('renders child content', () => {
    const wrapper = shallow(
      <Button>
        <span>Some <strong>text</strong></span>
      </Button>
    );
    expect(wrapper.contains(
      <span>Some <strong>text</strong></span>
    )).toBe(true);
  });

  it('renders a big green button', () => {
    const wrapper = shallow(
      <Button color="green"/>
    );
    expect(wrapper.hasClass('button--green')).toBe(true);
  });

  it('renders a small, default color button', () => {
    const wrapper = shallow(
      <Button size="small"/>
    );
    expect(wrapper.hasClass('button--small')).toBe(true);
  });

  it('renders a red button', () => {
    const wrapper = shallow(
      <Button color="red"/>
    );
    expect(wrapper.hasClass('button--red')).toBe(true);
  });

  it('renders a blue button', () => {
    const wrapper = shallow(
      <Button color="blue"/>
    );
    expect(wrapper.hasClass('button--blue')).toBe(true);
  });

  it('renders a yelow button', () => {
    const wrapper = shallow(
      <Button color="yellow"/>
    );
    expect(wrapper.hasClass('button--yellow')).toBe(true);
  });

  it('renders an icon type button', () => {
    const wrapper = shallow(
      <Button type="icon"/>
    );
    expect(wrapper.hasClass('button--icon')).toBe(true);
  });
});
