/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

jest.dontMock('./../../../views/component/Icon');

import {expect} from 'chai';
import React from 'react';
import ReactTestUtils from 'react-addons-test-utils';

const Icon = require('../../../views/component/Icon'),
  addIcon = '../../../../svg/add.svg';

describe('Icon', () => {
  const shallowRenderer = ReactTestUtils.createRenderer();

  it('renders a svg with default values', () => {
    shallowRenderer.render(
      <Icon glyph={addIcon}/>
    );
    const result = shallowRenderer.getRenderOutput();

    expect(result.type).to.equal('svg');

    expect(result.props.className).to.be.a('string');
    expect(result.props.className).to.equal('icon');

    expect(result.props.children.props.xlinkHref).to.be.a('string');
    expect(result.props.children.props).to.have.property('xlinkHref');
    expect(result.props.children.props.xlinkHref).to.equal(addIcon);
  });

  it('renders a svg without required props', () => {
    shallowRenderer.render(
      <Icon/>
    );
    const result = shallowRenderer.getRenderOutput();

    expect(result.type).to.equal('svg');

    expect(result.props.className).to.be.a('string');
    expect(result.props.children.props.xlinkHref).to.be.a('undefined');
    expect(result.props.className).to.equal('icon');
  });
});
