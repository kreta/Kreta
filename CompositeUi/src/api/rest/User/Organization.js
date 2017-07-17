/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import TaskManagerRest from './../TaskManagerRest';

class Organization {
  delete(organization, memberId, removerId) {
    const url = `/organization/${organization}/member/${memberId}?removerId=${removerId}`;

    return TaskManagerRest.deleteHttp(url);
  }
}

const instance = new Organization();

export default instance;
