/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import IdentityAccessRest from './../IdentityAccessRest';

class Register {
  signUp(credentials) {
    return IdentityAccessRest.post('/register', {
      email: credentials.email,
      'password[first]': credentials.password,
      'password[second]': credentials.repeated_password
    });
  }

  enable(token) {
    return IdentityAccessRest.get(`/enable?confirmation-token=${token}`);
  }
}

const instance = new Register();

export default instance;
