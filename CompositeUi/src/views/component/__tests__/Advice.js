/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {shallow} from 'enzyme';
import React from 'react';

import Advice from './../Advice';

describe('<Advice/>', () => {
  it('renders string title and child content', () => {
    const wrapper = shallow(
      <Advice>
        This is a dummy advice text.
      </Advice>
    );
    expect(wrapper.contains(
      <p className="advice">This is a dummy advice text.</p>
    )).toBe(true);
  });
});
