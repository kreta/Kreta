/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

const localStorageMock = () => {
  const store = {};

  return {
    setItem: (key, value) => {
      store[key] = value || '';
    },
    getItem: key => store[key] || null,
    removeItem: key => {
      Reflect.deleteProperty(store[key]);
    },
    get length() {
      return Object.keys(store).length;
    },
    key: key => {
      const keys = Object.keys(store);

      return keys[key] || null;
    },
  };
};

Reflect.defineProperty(window, 'localStorage', {value: localStorageMock});
