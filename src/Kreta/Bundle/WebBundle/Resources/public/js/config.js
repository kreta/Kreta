/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class Config {
  getBaseUrl () {
    var host = location.hostname + (location.port != "" ? ":" + location.port : '');
    return '//' + host + '/api';
  }
}
