/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Users from './../api/rest/User/Users';

class UserInjector {
  // Receives an array of objects containing and
  // ID and converts them into a user object.
  static injectUserForId(arrays) {
    return new Promise((resolve) => {
      const ids = [];
      arrays.forEach((user) => {
        ids.push(user.id);
      });

      Users.get({ids}).then((users) => {
        arrays.forEach((user, index) => {
          // eslint-disable-next-line max-nested-callbacks
          const found = users.find((it) => it.id === user.id);
          if (found) {
            Object.assign(arrays[index], found);
          }
        });
        resolve();
      });
    });
  }
}

export default UserInjector;
