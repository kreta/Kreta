/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class User extends Backbone.Model {
  defaults () {
    return {
    };
  }

  toString () {
    return this.get('first_name') + ' ' + this.get('last_name');
  }
}
