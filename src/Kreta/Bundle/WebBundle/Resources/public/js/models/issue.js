/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class Issue extends Backbone.Model {
  constructor (options) {
    this.url = App.config.getBaseUrl() + '/issues';
    super(options);
  }

  defaults () {
    return {
      title: '',
      description: ''
    };
  }
}
