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

import {expect, React, shallowRenderer} from './../../TestUtils';

const Icon = require('./../../../views/component/Icon'),
  AddIcon = './../../../../svg/add';

describe('Icon', () => {
  it('should be rendered', () => {
    shallowRenderer.render(
      <Icon glyph={AddIcon}/>
    );
    const result = shallowRenderer.getRenderOutput();

    expect(result.type).to.equal('svg');

    expect(result.props.children.props.xlinkHref).to.be.a('string');
    expect(result.props.children.props).to.have.property('xlinkHref');
    expect(result.props.children.props.xlinkHref).to.equal(AddIcon);
  });

  it('should not render without required glyph prop', () => {
    expect(() => shallowRenderer.render(
      <Icon/>
    )).to.throw(
      'Warning: Failed propType: Required prop `glyph` was not specified in `Icon`'
    );
  });

  it('should not render with glyph prop different of string type', () => {
    expect(() => shallowRenderer.render(
      <Icon glyph={{key: 'value'}}/>
    )).to.throw(
      'Warning: Failed propType: Invalid prop `glyph` of type `object` supplied to `Icon`, expected `string`.'
    );
  });
});
