jest.dontMock('../../../views/component/Icon.js');

import expect from 'expect';
import React from 'react';
import ReactDOM from 'react-dom';
import ReactTestUtils from 'react-addons-test-utils';

import Icon from '../../../views/component/Icon';

const addIcon = './../../../../svg/add.svg';

describe('Icon', () => {
  it('renders a svg', () => {

    let shallowRenderer = ReactTestUtils.createRenderer();
    //let icon = ReactTestUtils.renderIntoDocument(
    //    <Icon glyph={addIcon}/>
    //  ),
    //  iconNode = ReactDOM.findDOMNode(icon);

    shallowRenderer.render(
      <Icon glyph={addIcon}/>
    );
    let result = shallowRenderer.getRenderOutput();
    console.log(result);
    expect(result.type).toBe('svg');
  });

});
