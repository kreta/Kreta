/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

const localStorageMock = () => {
  let store = {};

  return {
    setItem: function (key, value) {
      store[key] = value || '';
    },
    getItem: function (key) {
      return store[key] || null;
    },
    removeItem: function (key) {
      delete store[key];
    },
    get length() {
      return Object.keys(store).length;
    },
    key: function (key) {
      const keys = Object.keys(store);

      return keys[key] || null;
    }
  }
};

Object.defineProperty(window, 'localStorage', {value: localStorageMock});
