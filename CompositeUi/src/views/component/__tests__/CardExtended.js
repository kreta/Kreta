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

import CardExtended from './../CardExtended';
import Thumbnail from './../Thumbnail';

describe('<CardExtended />', () => {
  it('renders basic component', () => {
    const wrapper = shallow(
      <CardExtended title="Example card"/>
    );
    expect(wrapper.find('.card-extended__header').text()).toBe('Example card');
    expect(wrapper.find('.card-extended__thumbnail')).toHaveLength(0);
    expect(wrapper.find('.card-extended__sub-header')).toHaveLength(0);
    expect(wrapper.find('.card-extended__actions').children()).toHaveLength(0);
  });

  it('renders title with thumbnail', () => {
    const wrapper = shallow(
      <CardExtended thumbnail={<Thumbnail text="me"/>} title="Example card"/>
    );
    expect(wrapper.find('.card-extended__header').text()).toBe('Example card');
    expect(wrapper.find('.card-extended__thumbnail').contains(<Thumbnail text="me"/>)).toBe(true);
    expect(wrapper.find('.card-extended__sub-header')).toHaveLength(0);
    expect(wrapper.find('.card-extended__actions').children()).toHaveLength(0);
  });

  it('renders title and subtitle with thumbnail', () => {
    const wrapper = shallow(
      <CardExtended subtitle="Example subtitle" thumbnail={<Thumbnail text="me"/>} title="Example card"/>
    );
    expect(wrapper.find('.card-extended__header').text()).toBe('Example card');
    expect(wrapper.find('.card-extended__thumbnail').contains(<Thumbnail text="me"/>)).toBe(true);
    expect(wrapper.find('.card-extended__sub-header').text()).toBe('Example subtitle');
    expect(wrapper.find('.card-extended__actions').children()).toHaveLength(0);
  });

  it('renders children as actions', () => {
    const wrapper = shallow(
      <CardExtended title="Example card">
        <a href="#">Add</a>
      </CardExtended>
    );
    expect(wrapper.find('.card-extended__header').text()).toBe('Example card');
    expect(wrapper.find('.card-extended__thumbnail')).toHaveLength(0);
    expect(wrapper.find('.card-extended__sub-header')).toHaveLength(0);
    expect(wrapper.find('.card-extended__actions').contains(<a href="#">Add</a>)).toBe(true);
  });
});
