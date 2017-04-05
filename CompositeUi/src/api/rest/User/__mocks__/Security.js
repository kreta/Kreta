/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

export default {
  login: (email, password) => (
    new Promise((resolve, reject) => {
      email === 'valid@email.com' && password === 'password' // eslint-disable-line no-unused-expressions
        ? resolve(new Promise(resolve => resolve({token: 'token'})))
        : reject(new Promise(resolve => resolve()));
    })
  ),
  logout: () => (
    new Promise((resolve) => {
      resolve();
    })
  )
};
