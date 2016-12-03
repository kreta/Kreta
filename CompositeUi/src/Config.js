/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

let Config = {
  baseUrl: `${location.hostname}`, // ${location.port !== '' ? `:${location.port}` : ''}`,
  shortcuts: {
    issueNew: 'n',
    notificationList: 'w',
    projectList: 'p',
    projectNew: 'x',
    projectSettings: 's',
    userProfile: 'm'
  }
};

Config = Object.assign({
  taskManagerUrl: `//${Config.baseUrl}:8001`,
  identityAccessUrl: `//${Config.baseUrl}:8002`,
}, Config);

export default Config;
