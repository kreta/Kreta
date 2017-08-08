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

class ResetPassword {
  request(email) {
    return IdentityAccessRest.post('/remember-password', {email}, {});
  }

  change(token, passwords) {
    return IdentityAccessRest.post(
      `/change-password?remember-password-token=${token}`,
      {
        'newPlainPassword[first]': passwords.password,
        'newPlainPassword[second]': passwords.repeated_password,
      },
      {},
    );
  }
}

const instance = new ResetPassword();

export default instance;
