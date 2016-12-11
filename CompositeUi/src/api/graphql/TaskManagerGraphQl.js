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
import GraphQl from './GraphQl';

class TaskManagerGraphQl extends GraphQl {
  baseUrl() {
    return Config.taskManagerUrl;
  }
}

const TaskManagerGraphQlInstance = new TaskManagerGraphQl();

export default TaskManagerGraphQlInstance;
