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

import DashboardWidget from '../DashboardWidget';
import SectionHeader from '../SectionHeader';

describe('<DashboardWidget/>', () => {
  it('renders string title and child content', () => {
    const wrapper = shallow(
      <DashboardWidget title="Title">
        <div>Content</div>
      </DashboardWidget>
    );
    expect(wrapper.find(SectionHeader)).toHaveLength(1);
    expect(wrapper.contains(
      <div>Content</div>
    )).toBe(true);
  });
});
