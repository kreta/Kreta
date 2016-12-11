/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Config from './../../Config';
import Rest from './Rest';

class TaskManagerRest extends Rest {
  baseUrl() {
    return Config.taskManagerUrl;
  }
}

const instance = new TaskManagerRest();

export default instance;
