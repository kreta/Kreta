/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {expect} from 'chai';
import React from 'react';
import ReactTestUtils from 'react-addons-test-utils';

const shallowRenderer = ReactTestUtils.createRenderer();
let {error} = console;

beforeEach(() => {
  console.error = jest.genMockFunction().mockImplementation(message => {
    throw new Error(message.replace(/Composite propType/, 'propType'));
  });
});

afterEach(() => {
  console.error = error;
});

export default {
  expect,
  React,
  ReactTestUtils,
  shallowRenderer
};
