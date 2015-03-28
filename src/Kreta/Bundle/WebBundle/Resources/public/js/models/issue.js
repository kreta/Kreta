/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class Issue extends Backbone.Model {
  urlRoot() {
    return  App.config.getBaseUrl() + '/issues';
  }

  defaults () {
    return {
      title: '',
      description: ''
    };
  }
}
