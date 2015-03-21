/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class Project extends Backbone.Model {
  defaults () {
    return {
      name: '',
      description: ''
    };
  }

  toString () {
    return this.get('name');
  }
}
